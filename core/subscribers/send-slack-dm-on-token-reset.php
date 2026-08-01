<?php
// Send a Slack DM when an admin resets a subscriber's token

add_action(
    'benecaster_token_reset_send_email',
    function ( int $token_id, int $user_id, int $show_id, string $new_token, string $custom_message ): void {
        $user     = get_userdata( $user_id );
        $feed_url = home_url( '/podcast-feed/?token=' . $new_token );

        wp_remote_post( MY_SLACK_WEBHOOK_URL, [
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    'Token reset for %s. New feed URL: %s. Admin note: %s',
                    $user->user_email,
                    $feed_url,
                    $custom_message ?: '(none)'
                ),
            ] ),
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
        ] );
    },
    10,
    5
);
