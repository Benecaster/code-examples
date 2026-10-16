<?php
// Create a tier or buy-up on a show that collects tax

$req = new WP_REST_Request( 'GET', '/benecaster/v1/membership/stripe/tax-status' );
$req->set_param( 'show_id', $show_id );
$needs_category = ! empty( rest_do_request( $req )->get_data()['category_required'] );

if ( $needs_category ) {
    // Do NOT pick a code. Ask the podcaster, then send what they chose:
    // $create->set_param( 'tax_code', $their_choice ); // e.g. 'txcd_10804010'
    my_tool_flag_tier_needs_category( $source_tier );
    return;
}
