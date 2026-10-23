<?php
// Sync a show's existing members from code after connecting its membership plugin

function my_sync_existing_members( int $show_id, bool $email_them ): array {
    $request = new WP_REST_Request( 'POST', "/benecaster/v1/shows/{$show_id}/member-sync" );
    $request->set_header( 'Content-Type', 'application/json' );
    $request->set_header( 'X-WP-Nonce', wp_create_nonce( 'wp_rest' ) );
    $request->set_body( wp_json_encode( [ 'send_welcome' => $email_them ] ) );
    $response = rest_do_request( $request );
    // 202: started. 409: refused, and the code says why (no_mapped_levels, unlicensed, running, ...).
    return [ $response->get_status(), $response->get_data() ];
}
