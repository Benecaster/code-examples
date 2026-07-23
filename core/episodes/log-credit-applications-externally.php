<?php
// Log credit applications to an external system.

/**
 * Post a Slack notification when a credit is applied to an episode.
 */
add_action(
    'benecaster_credit_applied',
    function ( int $episode_id, string $credit_id, string $stamped_text, int $show_id ): void {
        $webhook_url = get_option( 'my_plugin_slack_webhook' );
        if ( empty( $webhook_url ) ) {
            return;
        }

        $episode_title = get_the_title( $episode_id );
        $show_title    = get_the_title( $show_id );

        wp_remote_post( $webhook_url, [
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    'Credit stamped on *%s* (show: %s) — credit ID: `%s`',
                    $episode_title,
                    $show_title,
                    $credit_id
                ),
            ] ),
            'headers' => [ 'Content-Type' => 'application/json' ],
            'blocking' => false, // Fire-and-forget; don't block the save request.
        ] );
    },
    10,
    4
);
