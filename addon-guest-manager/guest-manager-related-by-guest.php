<?php
// Guest Manager's Same guest related episodes, and adjusting them

// Same guest, but only full episodes: drop trailers and bonus episodes from the list.
add_filter( 'benecaster_related_episodes', static function ( array $episodes, int $episode_id, int $show_id, array $args ): array {
    return array_values( array_filter(
        $episodes,
        static fn( WP_Post $e ): bool => 'full' === get_post_meta( $e->ID, '_benecaster_episode_type', true )
    ) );
}, 10, 4 );
