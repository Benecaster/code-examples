<?php
// Revoke a listener's feed only if they are not a member

// Register the reason as recoverable: if the person pays later, their
// original feed URL comes back. Required — a non-recoverable reason throws.
add_filter( 'benecaster_token_reactivation_recoverable_reasons', function ( array $reasons ): array {
    $reasons[] = 'my_addon_trial_ended';
    return $reasons;
} );

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    add_action( 'my_addon_trial_expiry', function ( int $user_id, int $show_id ) use ( $container ): void {
        $result = $container->make( \Benecaster\Token\TokenManager::class )
            ->revoke_unless_subscribed( $user_id, $show_id, 'my_addon_trial_ended' );

        if ( 'revoked' === $result ) {
            // Only now has access actually been taken away — email, log, count.
            do_action( 'my_addon_trial_ended', $user_id, $show_id );
        } elseif ( 'unknown' === $result ) {
            // The membership plugin could not answer. Try again tomorrow.
            wp_schedule_single_event( time() + DAY_IN_SECONDS, 'my_addon_trial_expiry', [ $user_id, $show_id ] );
        }
        // 'subscribed', 'converted', 'no_token' (or anything new): nothing was taken.
    }, 10, 2 );
} );
