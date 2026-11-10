<?php
// Invite a guest to the Guest portal, or stop their link, from code, and change the invitation email

// Invite a guest from code, e.g. when a booking form confirms them.
$request = new WP_REST_Request( 'POST', '/benecaster-guest-manager/v1/guests/' . $guest_id . '/invitation' );
$response = rest_do_request( $request );
if ( $response->is_error() ) {
    error_log( 'Guest portal invite refused: ' . $response->as_error()->get_error_code() );
}

// Add the show's booking contact to the bottom of every invitation.
add_filter( 'benecaster_guest_manager_invitation_email_message', static function ( string $message ): string {
    return $message . "\n\n" . __( 'Questions? Reply to bookings@example.com.', 'my-plugin' );
} );
