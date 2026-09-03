<?php
// Measure and log feed render time

add_action(
    'benecaster_feed_before_render',
    function ( int $show_id, string $tier_slug ): void {
        $GLOBALS['my_feed_render_start'] = microtime( true );
    },
    10,
    2
);

add_action(
    'benecaster_feed_after_render',
    function ( int $show_id, string $tier_slug, string $xml ): void {
        if ( empty( $GLOBALS['my_feed_render_start'] ) ) {
            return;
        }

        $ms = ( microtime( true ) - $GLOBALS['my_feed_render_start'] ) * 1000;
        unset( $GLOBALS['my_feed_render_start'] );

        // Only record the slow ones - feeds are polled far too often to log every request.
        if ( $ms < 250 ) {
            return;
        }

        error_log(
            sprintf(
                '[benecaster] slow feed render: show=%d tier=%s %.1fms %dKB',
                $show_id,
                $tier_slug !== '' ? $tier_slug : 'public',
                $ms,
                (int) ( strlen( $xml ) / 1024 )
            )
        );
    },
    10,
    3
);
