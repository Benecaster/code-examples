<?php
// Tune invalid token alerts per show

add_filter(
    'benecaster_invalid_token_alert_threshold',
    function ( array $config, int $show_id ) {
        // A staging or test show: no monitoring at all. Returning false
        // also stops benecaster_invalid_token_recorded for this show.
        if ( 123 === $show_id ) {
            return false;
        }

        // A high-traffic show: only alert on a heavier burst, over a
        // shorter window.
        if ( 456 === $show_id ) {
            return [ 'count' => 50, 'window_minutes' => 30 ];
        }

        return $config;
    },
    10,
    2
);
