<?php
// Log or alert when a subscriber's membership lapses while their token is still active

add_action( 'benecaster_subscriber_no_active_membership', function ( int $user_id, int $show_id ) {
    // Log for audit / CRM sync.
    error_log( sprintf( 'Benecaster: user %d has no active membership for show %d', $user_id, $show_id ) );

    // Optionally: queue a re-engagement email via your own system.
    do_action( 'my_crm_tag_subscriber', $user_id, 'benecaster_lapsed' );
}, 10, 2 );
