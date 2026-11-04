<?php
// Send a pre-publish choice with the publish

// Tiers that unlock in this request can read it directly. A tier scheduled for
// later unlocks from cron, where it is gone, so keep it now.
add_action( 'benecaster_episode_published', function ( int $episode_id ): void {
    $send = benecaster_get_episode_publish_data( 'my_addon_send' );
    if ( null !== $send ) {
        update_post_meta( $episode_id, '_my_addon_send', (bool) $send ? '1' : '0' );
    }
} );

add_action( 'benecaster_availability_unlocked', function ( int $episode_id, int $show_id, string $tier_slug ): void {
    if ( '0' === get_post_meta( $episode_id, '_my_addon_send', true ) ) {
        return;
    }
    my_addon_notify( $episode_id, $show_id, $tier_slug );
}, 10, 3 );
