<?php
// Pin a featured episode as "latest"

add_filter( 'benecaster_latest_episode_id', function ( ?int $episode_id, int $show_id ): ?int {
    $pinned = (int) get_post_meta( $show_id, '_my_featured_episode_id', true );
    if ( $pinned && 'publish' === get_post_status( $pinned ) ) {
        return $pinned;
    }
    return $episode_id; // Newest published episode, or null when there is none.
}, 10, 2 );
