<?php
// Send every Outlinks click to your own analytics as it happens

add_action( 'benecaster_outlinks_click_logged', function ( int $click_id, string $slug, ?int $episode_id, bool $is_bot ): void {
    if ( $is_bot ) {
        return; // Bot clicks are rows too, so the action fires for them.
    }
    my_analytics_queue( 'outlink_click', [ 'slug' => $slug, 'episode' => $episode_id ] );
}, 10, 4 );
