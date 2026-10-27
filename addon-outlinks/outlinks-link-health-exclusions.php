<?php
// Exclude domains, post types or categories from Link Health from code

wp_set_current_user( 1 );
$request = new WP_REST_Request( 'PATCH', '/benecaster-outlinks/v1/link-health/exclusions' );
$request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
$request->set_body_params( [ 'domains' => [ 'amazon.com', 'youtube.com' ] ] ); // post_types and categories are kept
$saved = rest_do_request( $request )->get_data(); // [ 'domains' => [ 'amazon.com', 'youtube.com' ], …, 'removed' => 12 ]
