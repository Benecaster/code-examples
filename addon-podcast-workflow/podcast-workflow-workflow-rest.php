<?php
// Change an episode's workflow status, outline or recording over REST

$request = new WP_REST_Request( 'PUT', '/benecaster-podcast-workflow/v1/shows/42/episodes/1234/workflow-status' );
$request->set_body_params( [ 'status' => 'review' ] );
$canvas = rest_do_request( $request )->get_data(); // $canvas['workflow']['status'] === 'review'
