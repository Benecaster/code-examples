<?php
// Show a different duration format in the admin only

add_filter( 'benecaster_admin_duration_display', function ( string $formatted, ?int $seconds ): string {
    if ( null === $seconds ) {
        return $formatted;
    }
    /* translators: %d: total minutes of an episode */
    return sprintf( __( '%d min', 'my-plugin' ), (int) round( $seconds / 60 ) );
}, 10, 2 );
