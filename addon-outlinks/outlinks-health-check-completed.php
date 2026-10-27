<?php
// Run your own code when a Link Health check finishes, with everything it found broken

add_action( 'benecaster_outlinks_health_check_completed', function ( array $broken_items, int $finished_at ): void {
    $redirects = array_filter( $broken_items, fn( array $item ): bool => 'redirect' === $item['kind'] );
    wp_remote_post( 'https://status.example.com/hooks/link-health', [
        'body' => wp_json_encode( [ 'at' => gmdate( 'c', $finished_at ), 'broken' => count( $broken_items ), 'tracked_links' => array_column( $redirects, 'slug' ) ] ),
    ] );
}, 10, 2 );
