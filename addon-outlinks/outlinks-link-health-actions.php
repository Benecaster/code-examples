<?php
// Dismiss, fix, unlink or track Link Health items from code, one at a time or in bulk

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'POST', '/benecaster-outlinks/v1/link-health/actions' );
$request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
$request->set_body_params( [
    'action' => 'update_url',
    'items'  => [ [ 'type' => 'site_link', 'id' => 41 ], [ 'type' => 'site_link', 'id' => 42 ] ],
    'url'    => 'https://example.com/new-page',
] );
foreach ( rest_do_request( $request )->get_data()['results'] as $result ) {
    if ( ! $result['ok'] ) {
        error_log( "Item {$result['id']}: {$result['code']}" );
    }
}
