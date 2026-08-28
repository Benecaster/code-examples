<?php
// Count paying subscribers correctly

// Count paying subscribers for a single show.
$count = benecaster_get_subscriber_count( $show_id );

// Same figure, site-wide — matches the daily license-server subscriber_count.
$site_count = 0;

foreach ( get_posts( [
    'post_type'      => 'benecaster_show',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
] ) as $id ) {
    $site_count += benecaster_get_subscriber_count( $id );
}
