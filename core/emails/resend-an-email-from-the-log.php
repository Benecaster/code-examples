<?php
// Resend an email from the log

add_action( 'rest_api_init', function (): void {
    register_rest_route( 'my-addon/v1', '/email-log/(?P<id>\d+)/resend', [
        'methods'             => 'POST',
        'permission_callback' => static fn(): bool => current_user_can( 'manage_options' ),
        'callback'            => static function ( WP_REST_Request $request ) {
            $result = benecaster_resend_email( (int) $request['id'] );
            // A WP_Error carries its HTTP status, so return it as it is.
            return is_wp_error( $result ) ? $result : [ 'queue_id' => $result ];
        },
    ] );
} );

// Count resends separately: benecaster_after_email_send does not fire for one.
add_action( 'benecaster_email_resent', function ( ?int $user_id, ?int $show_id, string $type, int $log_id ): void {
    my_addon_note( "Resent {$type} (log {$log_id})" );
}, 10, 4 );
