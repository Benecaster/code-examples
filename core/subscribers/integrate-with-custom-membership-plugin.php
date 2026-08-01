<?php
// Integrate with a membership plugin not in the core bridge set

class MyPlugin_Bridge implements \Benecaster\Bridge\BridgeInterface {

    public function __construct(
        private readonly \Benecaster\Show\TierMapRepository $tier_map
    ) {}

    public function get_plugin_slug(): string {
        return 'my-plugin';
    }

    public function get_user_tier( int $user_id, int $show_id ): ?string {
        $level_ids = my_plugin_get_active_levels( $user_id );
        foreach ( $level_ids as $level_id ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier && (int) $tier->show_id === $show_id ) {
                return $tier->internal_tier_slug;
            }
        }
        return null;
    }

    public function is_user_active( int $user_id, int $show_id ): bool {
        return $this->get_user_tier( $user_id, $show_id ) !== null;
    }

    public function get_all_tiers( int $show_id ): array {
        return array_map( fn( $level ) => [
            'id'   => $level->id,
            'name' => $level->name,
        ], my_plugin_get_all_levels() );
    }

    public function on_subscription_activated( callable $callback ): void {
        add_action( 'my_plugin_member_activated', function ( $user_id, $level_id ) use ( $callback ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier ) {
                $callback( $user_id, (int) $tier->show_id, $tier->internal_tier_slug, 'new' );
            }
        }, 10, 2 );
    }

    public function on_subscription_cancelled( callable $callback ): void {
        add_action( 'my_plugin_member_cancelled', function ( $user_id, $level_id ) use ( $callback ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier ) {
                $callback( $user_id, (int) $tier->show_id );
            }
        }, 10, 2 );
    }

    public function on_subscription_changed( callable $callback ): void {} // no-op

    public function on_subscription_renewed( callable $callback ): void {
        // Wire to your plugin's renewal hook.
    }

    public function on_payment_failed( callable $callback ): void {
        // Wire to your plugin's payment failure hook.
    }
}

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    $bridge = new MyPlugin_Bridge(
        $container->make( \Benecaster\Show\TierMapRepository::class )
    );
    $container->make( \Benecaster\Bridge\BridgeManager::class )
              ->set_active_bridge( YOUR_SHOW_ID, 'my-plugin' );
} );
