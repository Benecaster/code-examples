<?php
// Add Manual Membership Support to a Custom Bridge

// 1. In your bridge class, implement create_manual_membership() directly.
//    Do not use ManualMembershipUnsupportedTrait in a bridge that implements it.
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
        $sub_id = $sub_repo->insert( [
            'user_id'          => $user_id,
            'show_id'          => $show_id,
            'tier_slug'        => $tier_slug,
            'billing_interval' => 'monthly',
            'status'           => 'active',
        ] );

        // Mint a Benecaster feed token for the subscriber. generate() returns the
        // plaintext token, or null when they already hold one on this show (their
        // existing feed URL stands); either way, read the row back below.
        $token_manager = \Benecaster\Plugin::instance()->make(
            \Benecaster\Token\TokenManager::class
        );
        $token_manager->generate( $user_id, $show_id, $tier_slug );

        $token_repo = \Benecaster\Plugin::instance()->make(
            \Benecaster\Token\TokenRepository::class
        );
        $token_row = $token_repo->find_by_user_and_show( $user_id, $show_id );
        if ( null === $token_row ) {
            throw new \RuntimeException( 'Subscription was created but no token was minted.' );
        }

        // Stamp is_manual_grant and optional expiry on the token row.
        $token_repo->set_manual_grant( (int) $token_row->id, true, $expiry_at );

        return [
            'subscription_id' => $sub_id,
            'token_prefix'    => (string) $token_row->token_prefix,
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
