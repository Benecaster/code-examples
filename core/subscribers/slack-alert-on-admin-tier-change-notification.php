<?php
// Send a Slack alert when an admin changes a subscriber's tier and notifies them

add_action(
    'benecaster_admin_tier_change_notify',
    function ( int $token_id, int $user_id, int $show_id, string $old_tier, string $new_tier ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        wp_remote_post( MY_SLACK_WEBHOOK_URL, [
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    'Tier change: %s moved from %s to %s (show %d).',
                    $user->user_email,
                    $old_tier,
                    $new_tier,
                    $show_id
                ),
            ] ),
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
        ] );
    },
    10,
    5
);
