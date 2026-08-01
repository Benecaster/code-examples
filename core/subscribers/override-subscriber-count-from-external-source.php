<?php
// Override subscriber count from an external analytics source

add_filter( 'benecaster_analytics_subscriber_count', function ( int $count, int $show_id ): int {
    $external = (int) get_transient( 'my_subscriber_count_' . $show_id );
    return $external > 0 ? $external : $count; // fall back to Benecaster count on cache miss
}, 10, 2 );
