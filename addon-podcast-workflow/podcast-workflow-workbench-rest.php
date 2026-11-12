<?php
// Read the Podcast Workflow Workbench over REST

$request  = new WP_REST_Request( 'GET', '/benecaster-podcast-workflow/v1/shows/42/episodes/1234/workbench' );
$response = rest_do_request( $request );
if ( 409 === $response->get_status() ) {
    $home = $response->get_data()['data']['episode_show_id']; // ask again under that show
}
