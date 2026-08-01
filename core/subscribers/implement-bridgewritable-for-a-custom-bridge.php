<?php
// Opt a custom bridge into the Promote-to-Bridge migration wizard

use Benecaster\Bridge\BridgeInterface;
use Benecaster\Bridge\BridgeWritable;

class MyPlugin_Bridge implements BridgeInterface, BridgeWritable {

    public function can_import(): bool {
        return function_exists( 'my_plugin_grant_membership' );
    }

    public function supports_tier( int $tier_id ): bool {
        return $tier_id > 0 && (bool) my_plugin_get_level( $tier_id );
    }

    public function create_member( string $email, int $user_id, int $tier_id, array $meta = [] ): bool {
        if ( ! $this->can_import() || ! $this->supports_tier( $tier_id ) ) {
            return false;
        }
        try {
            // Use your plugin's canonical "grant membership" API. Do NOT create
            // sham orders / charges — the wizard's grace period handles payment
            // re-authorization out-of-band.
            return (bool) my_plugin_grant_membership( $user_id, $tier_id, [
                'created_via' => 'benecaster_migration',
            ] );
        } catch ( \Throwable $e ) {
            return false;
        }
    }

    // ... BridgeInterface methods (get_user_tier, on_subscription_activated, etc.)
}
