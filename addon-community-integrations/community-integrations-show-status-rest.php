<?php
// Read a show's community sync status, or start a resync, from code

// A nightly check: resync any show whose community has failures.
$status = rest_do_request( new WP_REST_Request( 'GET', "/benecaster-community-integrations/v1/shows/{$show_id}/community" ) )->get_data();
if ( ( $status['sync']['failed'] ?? 0 ) > 0 ) {
    rest_do_request( new WP_REST_Request( 'POST', "/benecaster-community-integrations/v1/shows/{$show_id}/resync" ) );
}
