<?php
// Track a show's references from code, read their click counts, or set their affiliate URL, country rules and expiry

$request = new WP_REST_Request( 'POST', '/benecaster-outlinks/v1/shows/12/redirects' );
$request->set_body_params( [ 'reference_id' => 41, 'slug' => 'lean-startup' ] );
$response = rest_do_request( $request ); // As a user with manage_options.

if ( $response->is_error() && 'benecaster_outlinks_slug_taken' === $response->as_error()->get_error_code() ) {
    $suggestion = $response->as_error()->get_error_data()['suggestion']; // e.g. 'lean-startup-2'
}
