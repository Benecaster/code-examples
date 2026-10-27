<?php
// Send every Outlinks click to your own analytics as it happens

add_action( 'benecaster_outlinks_click_logged', function ( int $click_id, string $slug, ?int $episode_id ): void {
    global $wpdb;
    $is_bot = (bool) $wpdb->get_var( $wpdb->prepare(
        "SELECT is_bot FROM {$wpdb->prefix}benecaster_outlinks_clicks WHERE id = %d", $click_id
    ) );
    if ( $is_bot ) {
        return; // Bot clicks are rows too, so the action fires for them.
    }
    my_analytics_queue( 'outlink_click', [ 'slug' => $slug, 'episode' => $episode_id ] );
}, 10, 3 );
