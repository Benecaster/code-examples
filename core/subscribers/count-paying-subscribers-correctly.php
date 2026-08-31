<?php
// Count paying subscribers correctly
//
// benecaster_get_subscriber_count() returns every active token for the show —
// paying subscribers, free-tier bridge members and followers together. It is
// useful as an audience size and wrong as a paying count. A documented
// paying-only helper is not public yet.

$all_tokens = benecaster_get_subscriber_count( $show_id );

// Site-wide, same caveat.
$site_tokens = 0;

foreach ( get_posts( [
    'post_type'      => 'benecaster_show',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'fields'         => 'ids',
] ) as $id ) {
    $site_tokens += benecaster_get_subscriber_count( $id );
}
