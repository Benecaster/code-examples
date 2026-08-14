<?php
// Add Manual Membership Support to a Custom Bridge

// 1. In your bridge class, implement create_manual_membership() directly.
//    Remove ManualMembershipUnsupportedTrait if you previously used it.
class AcmeMembershipBridge implements \Benecaster\Bridge\BridgeInterface {

    // ... other BridgeInterface methods ...

    public function create_manual_membership(
        int     $user_id,
        int     $show_id,
        string  $tier_slug,
        ?string $expiry_at
    ): array {
        // Create or retrieve the member in Acme's data model.
        acme_membership_create_or_get( $user_id, $tier_slug );

        // Provision a Benecaster subscription row via SubscriptionRepository.
        $sub_repo = \Benecaster\Plugin::instance()->make(
            \Benecaster\Membership\SubscriptionRepository::class
        );
        $sub_id = $sub_repo->create( [
            'user_id'   => $user_id,
            'show_id'   => $show_id,
            'tier_slug' => $tier_slug,
            'status'    => 'active',
            'source'    => 'manual',
        ] );

        // Generate a Benecaster feed token for the subscriber.
        $token_manager = \Benecaster\Plugin::instance()->make(
            \Benecaster\Token\TokenManager::class
        );
        $token = $token_manager->generate( $user_id, $show_id, $tier_slug );

        // Stamp is_manual_grant and optional expiry on the token row.
        $token_repo = \Benecaster\Plugin::instance()->make(
            \Benecaster\Token\TokenRepository::class
        );
        $token_repo->set_manual_grant( $token->id, true, $expiry_at );

        return [
            'subscription_id' => $sub_id,
            'token_prefix'    => substr( $token->hash, 0, 8 ),
        ];
    }
}

// 2. Flip the gate filter so Benecaster renders the "Add subscriber manually"
//    button on shows using your bridge, and routes the endpoint to your implementation.
add_filter( 'benecaster_bridge_supports_manual_membership', function ( bool $default, string $bridge_slug ): bool {
    if ( 'acme-membership' === $bridge_slug ) {
        return true;
    }
    return $default;
}, 10, 2 );
