<?php
// Show short-form durations: 1hr 2mins

add_filter( 'benecaster_duration_display', function ( string $formatted, ?int $seconds ): string {
    if ( null === $seconds ) {
        return $formatted;
    }
    $minutes = $seconds > 0 ? max( 1, (int) round( $seconds / 60 ) ) : 0;
    $hours   = intdiv( $minutes, 60 );
    $minutes = $minutes % 60;

    if ( 0 === $hours ) {
        return sprintf( '%dmins', $minutes );               // 47mins
    }
    return sprintf( '%dhr %dmins', $hours, $minutes );      // 1hr 2mins
}, 10, 2 );
