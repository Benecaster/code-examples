<?php
// Keep a provider API key encrypted, and never show it back

add_action( 'rest_api_init', static function (): void {
    register_rest_route( 'my-addon/v1', '/settings', [
        [
            'methods'             => 'GET',
            'permission_callback' => static fn() => current_user_can( 'manage_options' ),
            'callback'            => static fn() => [
                // Yes or no — never the key, not even to an administrator.
                'api_key_set' => null !== benecaster_get_secret( 'my-addon', 'api_key' ),
            ],
        ],
        [
            'methods'             => 'POST',
            'permission_callback' => static fn() => current_user_can( 'manage_options' ),
            'callback'            => static function ( \WP_REST_Request $request ) {
                $key = trim( (string) $request->get_param( 'api_key' ) );
                if ( '' === $key ) {
                    benecaster_delete_secret( 'my-addon', 'api_key' );
                } elseif ( ! benecaster_store_secret( 'my-addon', 'api_key', $key ) ) {
                    return new \WP_Error( 'not_stored', __( 'The key could not be saved.', 'my-addon' ), [ 'status' => 500 ] );
                }
                return [ 'api_key_set' => '' !== $key ];
            },
        ],
    ] );
} );

// At the point of use.
function my_addon_call_provider(): void {
    $key = benecaster_get_secret( 'my-addon', 'api_key' );
    if ( null === $key ) {
        return; // Not set, or unreadable after a key change — show "add your API key" in your settings.
    }
    // … call the provider with $key.
}
