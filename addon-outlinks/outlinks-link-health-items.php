<?php
// List what Link Health has found — broken, redirected, expired, dismissed — from code

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'GET', '/benecaster-outlinks/v1/link-health/items' );
$request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
$request->set_query_params( [ 'source' => 'episode', 'status' => 'broken', 'per_page' => 100 ] );
foreach ( rest_do_request( $request )->get_data()['items'] as $item ) {
    printf( "%s in %s (%s)\n", $item['url'], $item['source_title'], $item['http_status'] ?? 'no response' );
}
