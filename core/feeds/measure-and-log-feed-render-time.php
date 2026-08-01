<?php
// Measure and log feed render time

add_action( 'benecaster_feed_before_render', function ( int $show_id, string $tier_slug ) {
    $GLOBALS['_benecaster_render_start'] = microtime( true );
}, 10, 2 );

add_action( 'benecaster_feed_after_render', function ( int $show_id, string $tier_slug, string $xml ) {
    $elapsed_ms = round( ( microtime( true ) - ( $GLOBALS['_benecaster_render_start'] ?? 0 ) ) * 1000 );
    $size_kb    = round( strlen( $xml ) / 1024, 1 );
    error_log( sprintf( 'Benecaster feed rendered: show=%d tier=%s time=%dms size=%skb',
        $show_id, $tier_slug, $elapsed_ms, $size_kb ) );
}, 10, 3 );
