<?php
// Send yourself a review copy of a logged email

add_action( 'rest_api_init', function (): void {
    register_rest_route( 'my-addon/v1', '/email-log/(?P<id>\d+)/review-copy', [
        'methods'             => 'POST',
        'permission_callback' => static fn(): bool => current_user_can( 'manage_options' ),
        'callback'            => static function ( WP_REST_Request $request ) {
            // Always to the person asking: never take a recipient from the request.
            $result = benecaster_forward_email_to_admin( (int) $request['id'], get_current_user_id() );
            return is_wp_error( $result ) ? $result : [ 'queue_id' => $result ];
        },
    ] );
} );
