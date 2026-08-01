<?php
// Redirect episode navigation links

// Skip bonus episodes in the prev/next links.
add_filter( 'benecaster_episode_nav_next', function ( ?\WP_Post $next, int $episode_id, int $show_id ): ?\WP_Post {
    while ( $next instanceof \WP_Post ) {
        $type = get_post_meta( $next->ID, '_benecaster_episode_type', true );
        if ( $type !== 'bonus' ) {
            break;
        }
        $candidates = get_posts( [
            'post_type'   => 'benecaster_episode',
            'post_parent' => $show_id,
            'post_status' => 'publish',
            'date_query'  => [ [ 'after' => $next->post_date_gmt, 'column' => 'post_date_gmt' ] ],
            'orderby'     => 'date',
            'order'       => 'ASC',
            'numberposts' => 1,
        ] );
        $next = $candidates[0] ?? null;
    }
    return $next;
}, 10, 3 );
