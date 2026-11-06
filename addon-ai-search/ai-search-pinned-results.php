<?php
// Manage or change AI Search's pinned results

// During a live event, pin the event page for "live" on show 12, ahead of the podcaster's own pins.
add_filter( 'benecaster_ai_search_pinned_results', function ( array $pins, string $query, int $show_id ): array {
    if ( 12 === $show_id && false !== stripos( $query, 'live' ) ) {
        array_unshift( $pins, [ 'post_id' => 345, 'keyword' => 'live', 'priority' => 0 ] );
    }
    return $pins;
}, 10, 3 );
