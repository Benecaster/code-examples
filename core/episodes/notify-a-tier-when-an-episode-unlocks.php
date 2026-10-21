<?php
// Notify a tier once when an episode opens to it

add_action( 'benecaster_availability_unlocked', function ( int $episode_id, int $show_id, string $tier_slug, int $available_datetime ) {
    // Skip back-dated publishes: anything that "unlocked" more than two days ago is not news.
    if ( $available_datetime < time() - 2 * DAY_IN_SECONDS ) {
        return;
    }
    my_push_service_notify_tier( $show_id, $tier_slug, sprintf(
        /* translators: %s: episode title */
        __( 'New episode for you: %s', 'my-plugin' ),
        get_the_title( $episode_id )
    ) );
}, 10, 4 );
