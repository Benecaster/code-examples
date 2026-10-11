<?php
// Point your clients at your own help page when an add-on install is refused

add_filter( 'benecaster_manager_install_error_message', function ( string $message, string $code, string $slug ): string {
    if ( 'benecaster_manager_not_entitled' !== $code ) {
        return $message;
    }
    return $message . ' ' . __( 'Ask your agency to add it to your plan: help.example.com/addons', 'my-agency' );
}, 10, 3 );
