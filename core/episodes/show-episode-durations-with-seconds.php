<?php
// Bring the seconds back on the website

add_filter( 'benecaster_duration_display', function ( string $formatted, ?int $seconds ): string {
    if ( null === $seconds ) {
        return $formatted;
    }
    $hours = intdiv( $seconds, 3600 );
    return $hours > 0
        ? sprintf( '%d:%02d:%02d', $hours, intdiv( $seconds % 3600, 60 ), $seconds % 60 ) // 1:02:03
        : sprintf( '%d:%02d', intdiv( $seconds, 60 ), $seconds % 60 );                    // 47:23
}, 10, 2 );
