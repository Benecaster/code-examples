<?php
// Read and add an episode's production notes through Podcast Workflow's REST routes

$request = new WP_REST_Request( 'POST', '/benecaster-podcast-workflow/v1/shows/42/episodes/1234/notes' );
$request->set_body_params( [ 'content' => "Guest asked to cut the bit about the dog.\nKeep the outro." ] );
$notes = rest_do_request( $request )->get_data()['notes'];
