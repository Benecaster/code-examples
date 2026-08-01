<?php
// Override the related-episodes list per-episode

// On a "coming soon" episode, show no related episodes.
add_filter(
    'benecaster_related_episodes',
    function ( array $episodes, int $episode_id, int $show_id, array $args ): array {
        $status = get_post_meta( $episode_id, '_my_addon_launch_status', true );
        return $status === 'coming_soon' ? [] : $episodes;
    },
    10, 4
);
