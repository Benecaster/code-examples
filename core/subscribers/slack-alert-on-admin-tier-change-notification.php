<?php
// Send a Slack alert when a subscriber's tier changes

add_action(
    'benecaster_subscription_tier_changed',
    function ( int $user_id, int $show_id, string $old_tier_slug, string $new_tier_slug ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        wp_remote_post( MY_SLACK_WEBHOOK_URL, [
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    'Tier change: %s moved from %s to %s (show %d).',
                    $user->user_email,
                    $old_tier_slug,
                    $new_tier_slug,
                    $show_id
                ),
            ] ),
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
        ] );
    },
    10,
    4
);
