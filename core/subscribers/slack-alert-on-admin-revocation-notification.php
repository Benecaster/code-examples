<?php
// Send a Slack alert when an admin revokes a subscriber's access and notifies them

add_action(
    'benecaster_admin_revoke_notify',
    function ( int $token_id, int $user_id, int $show_id ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        wp_remote_post( MY_SLACK_WEBHOOK_URL, [
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    'Access revoked: %s removed from show %d.',
                    $user->user_email,
                    $show_id
                ),
            ] ),
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
        ] );
    },
    10,
    3
);
