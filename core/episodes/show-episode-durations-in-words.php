<?php
// Show durations in words on the website

add_filter( 'benecaster_duration_display', function ( string $formatted, ?int $seconds ): string {
    if ( null === $seconds ) {
        return $formatted; // free text the podcaster typed: leave it alone
    }
    $minutes = $seconds > 0 ? max( 1, (int) round( $seconds / 60 ) ) : 0;
    $hours   = intdiv( $minutes, 60 );
    $minutes = $minutes % 60;

    /* translators: %d: number of hours */
    $h = sprintf( _n( '%d hour', '%d hours', $hours, 'my-theme' ), $hours );
    /* translators: %d: number of minutes */
    $m = sprintf( _n( '%d minute', '%d minutes', $minutes, 'my-theme' ), $minutes );

    if ( 0 === $hours ) {
        return $m;                           // 47 minutes
    }
    return 0 === $minutes ? $h : "$h $m";    // 1 hour, 1 hour 2 minutes
}, 10, 2 );
