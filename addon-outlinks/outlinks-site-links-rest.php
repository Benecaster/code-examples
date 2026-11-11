<?php
// Create, find, list or edit site-wide Outlinks links over REST

$request = new WP_REST_Request( 'POST', '/benecaster-outlinks/v1/site-links' );
$request->set_body_params( [ 'url' => 'https://example.com/books/the-lean-startup', 'slug' => 'lean-startup-book' ] );
$response = rest_do_request( $request ); // As a user with manage_options.
$go_url   = $response->is_error() ? null : $response->get_data()['go_url'];
