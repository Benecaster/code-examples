<?php
// Add a custom REST endpoint from your add-on

add_action( 'rest_api_init', function (): void {
    register_rest_route( 'my-addon/v1', '/my-resource', [
        'methods'             => 'GET',
        'callback'            => 'my_addon_get_resource',
        'permission_callback' => 'benecaster_rest_permission_admin',
    ] );
} );

function my_addon_get_resource( \WP_REST_Request $request ): \WP_REST_Response {
    return new \WP_REST_Response( [ 'data' => 'hello from my add-on' ], 200 );
}
