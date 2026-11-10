<?php
// Approve or decline guests' Guest portal changes from code, and change the approval emails

// Send submissions to the producer instead of the site's admin.
add_filter( 'benecaster_guest_manager_approval_email_recipient', static fn(): string => 'producer@example.com' );

// Approve every waiting change from code, e.g. a trusted guest list in a cron job.
$waiting = rest_do_request( new WP_REST_Request( 'GET', '/benecaster-guest-manager/v1/approvals' ) )->get_data();
foreach ( $waiting['items'] as $item ) {
    rest_do_request( new WP_REST_Request( 'POST', '/benecaster-guest-manager/v1/approvals/' . $item['guest_id'] . '/approve' ) );
}
