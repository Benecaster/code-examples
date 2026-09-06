<?php
// Close the re-authorization gap yourself by vetoing an unnecessary expiry

add_filter( 'benecaster_promote_grace_expiry_should_revoke', function ( bool $should_revoke, array $promotion, int $user_id ): bool {
    // Only intervene for the destination plugin we actually know how to ask.
    if ( 'memberpress' !== ( $promotion['promoted_to_bridge'] ?? '' ) ) {
        return $should_revoke;
    }

    if ( ! my_destination_plugin_has_active_payment_method( $user_id ) ) {
        return $should_revoke; // Let the expiry proceed as normal.
    }

    // They finished setting up. Resolve the row so it stops coming back to us
    // and so the podcaster sees it as cleared in Promotion History.
    \Benecaster\Plugin::instance()
        ->make( \Benecaster\Bridge\PromotionService::class )
        ->clear_grace_period( (int) $promotion['id'] );

    return false;
}, 10, 3 );
