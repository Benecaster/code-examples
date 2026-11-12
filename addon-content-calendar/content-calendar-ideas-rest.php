<?php
// Read, write, rearrange and promote a show's Content Calendar ideas over REST

$request = new WP_REST_Request( 'POST', '/benecaster-content-calendar/v1/shows/42/ideas' );
$request->set_body_params( [ 'type' => '', 'type_name' => '', 'title' => 'Listener mailbag', 'notes' => 'From the October episodes' ] );
$idea = rest_do_request( $request )->get_data();
