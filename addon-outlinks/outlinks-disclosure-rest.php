<?php
// Read or change a show's Outlinks affiliate disclosure settings from code

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'PATCH', '/benecaster-outlinks/v1/shows/12/disclosure' );
$request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
$request->set_body_params( [ 'text' => 'We earn from qualifying purchases.' ] );
$settings = rest_do_request( $request )->get_data(); // [ 'enabled' => true, 'text' => 'We earn from qualifying purchases.', … ]
