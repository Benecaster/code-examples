<?php
// Keep an email list right through a license lapse

add_action( 'benecaster_token_quietly_revoked', function ( int $token_id, int $user_id, int $show_id, string $reason, string $tier_slug ): void {
    as_enqueue_async_action( 'my_addon_remove_tier_tag', [ $user_id, $show_id, $tier_slug ] );
    // Only a real cancellation is a cancellation. A license lapse is not the listener leaving.
    if ( 'bridge_cancellation' === $reason ) {
        as_enqueue_async_action( 'my_addon_tag_cancelled', [ $user_id, $show_id ] );
    }
}, 10, 5 );

add_action( 'benecaster_token_quietly_restored', function ( int $token_id, int $user_id, int $show_id, string $tier_slug ): void {
    as_enqueue_async_action( 'my_addon_apply_tier_tag', [ $user_id, $show_id, $tier_slug ] );
}, 10, 4 );
