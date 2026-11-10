<?php
// Restyle the guest's own Guest portal form, or act when a guest sends changes

// Email the show's producer the moment a guest sends changes.
add_action( 'benecaster_guest_manager_after_submit_guest_changes', static function ( int $guest_id, array $pending ): void {
    wp_mail( 'producer@example.com', 'Guest changes waiting', get_the_title( $guest_id ) . ' changed: ' . implode( ', ', array_keys( $pending['fields'] ) ) );
}, 10, 2 );

// Offer two blank social rows instead of three.
add_filter( 'benecaster_guest_manager_guest_form_data', static function ( array $form ): array {
    if ( 'form' === $form['state'] ) {
        $form['blank_rows'] = 2;
    }
    return $form;
} );
