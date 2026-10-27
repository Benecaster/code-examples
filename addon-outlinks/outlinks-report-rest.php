<?php
// Read a show's Outlinks click report from code — people, filtered clicks, last click and clicks by episode

$request  = new WP_REST_Request( 'GET', '/benecaster-outlinks/v1/shows/12/report' );
$response = rest_do_request( $request ); // As a user with manage_options.

foreach ( $response->get_data()['items'] as $link ) {
    printf( "%s: %d people, %d filtered\n", esc_html( $link['label'] ?? $link['slug'] ), $link['clicks'], $link['bot_clicks'] );
}
