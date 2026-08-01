<?php
// Assign episode numbers based on a custom sequence

// Suppress auto-numbering for non-full episodes (trailers, bonus).
add_filter( 'benecaster_episode_auto_number', function ( int $next, int $episode_id, int $show_id ): int {
    $type = get_post_meta( $episode_id, '_benecaster_episode_type', true );
    if ( 'full' !== $type ) {
        return 0; // 0 = skip auto-numbering.
    }
    return $next;
}, 10, 3 );
