<?php
// Log admin-initiated revocations to an external audit service

add_action(
    'benecaster_subscriber_access_revoked',
    function ( int $user_id, int $show_id ): void {
        $user = get_userdata( $user_id );
        my_audit_log_write( [
            'event'   => 'subscriber_access_revoked',
            'actor'   => 'admin',
            'email'   => $user ? $user->user_email : "user:{$user_id}",
            'show_id' => $show_id,
            'at'      => gmdate( 'Y-m-d\TH:i:s\Z' ),
        ] );
    },
    10,
    2
);
