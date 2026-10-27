<?php
// Change how often Link Health checks and emails, or switch the digest off, from code

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'PATCH', '/benecaster-outlinks/v1/link-health/settings' );
$request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
$request->set_body_params( [ 'check_frequency' => 'daily', 'digest_frequency' => 'daily' ] );
$settings = rest_do_request( $request )->get_data(); // [ 'check_frequency' => 'daily', 'digest_frequency' => 'daily' ]
