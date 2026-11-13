<?php
// List a show's Outlinks links and count their clicks from another add-on — a sponsor's links, per episode and channel

// A sponsor's links on one show: clicks per episode and channel for November.
if ( function_exists( 'benecaster_outlinks_count_clicks' ) ) {
    $rows       = benecaster_outlinks_count_clicks( $show_id, $sponsor_redirect_ids, '2026-11-01', '2026-11-30' );
    $by_episode = [];
    foreach ( is_wp_error( $rows ) ? [] : $rows as $row ) {
        $episode = $row['episode_id'] ?? 0; // 0: not from an episode.
        $by_episode[ $episode ][ $row['referrer_type'] ] = ( $by_episode[ $episode ][ $row['referrer_type'] ] ?? 0 ) + $row['clicks'];
    }
}

// The picker: every link of the show, by label or slug.
$choices = function_exists( 'benecaster_outlinks_get_redirects' ) ? benecaster_outlinks_get_redirects( $show_id ) : [];
