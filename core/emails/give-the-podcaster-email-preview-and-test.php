<?php
// Give the podcaster "Preview" and "Send me a test" for any email

add_action( 'rest_api_init', static function (): void {
    register_rest_route( 'my-addon/v1', '/emails/(?P<type>[a-z_]+)/preview', [
        'methods'             => 'GET',
        'permission_callback' => static fn() => current_user_can( 'manage_options' ),
        'callback'            => static function ( \WP_REST_Request $request ) {
            $type    = (string) $request['type'];
            $show_id = absint( $request->get_param( 'show_id' ) ) ?: null;
            return [
                'preview' => benecaster_render_email_preview( $type, [], $show_id ), // subject, html, text
                'tags'    => benecaster_get_email_merge_tag_catalog( $type ),         // for the autocomplete
            ];
        },
    ] );

    register_rest_route( 'my-addon/v1', '/emails/(?P<type>[a-z_]+)/test', [
        'methods'             => 'POST',
        'permission_callback' => static fn() => current_user_can( 'manage_options' ),
        'callback'            => static function ( \WP_REST_Request $request ) {
            $to       = sanitize_email( (string) $request->get_param( 'to' ) ) ?: wp_get_current_user()->user_email;
            $queue_id = benecaster_send_test_email( (string) $request['type'], $to, [], absint( $request->get_param( 'show_id' ) ) ?: null );
            return 0 < $queue_id ? [ 'queued' => true ] : new \WP_Error( 'not_sent', __( 'The test could not be sent.', 'my-addon' ), [ 'status' => 400 ] );
        },
    ] );
} );
