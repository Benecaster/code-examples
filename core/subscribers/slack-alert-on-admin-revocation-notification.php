<?php
// Send a Slack alert when a subscriber's access is revoked

add_action(
    'benecaster_subscriber_access_revoked',
    function ( int $user_id, int $show_id ): void {
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
    2
);
