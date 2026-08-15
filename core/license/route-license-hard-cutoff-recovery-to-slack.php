<?php
// Resolve the Outage Alert When Access Is Restored

add_action(
    'benecaster_license_payment_grace_recovered',
    function ( int $restored_count, int $started_at ): void {
        $hours = (int) round( ( time() - $started_at ) / HOUR_IN_SECONDS );

        // Resolve the PagerDuty incident opened at cutoff — same dedup_key.
        wp_remote_post( 'https://events.pagerduty.com/v2/enqueue', [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
            'body'    => wp_json_encode( [
                'routing_key'  => MY_PAGERDUTY_ROUTING_KEY,
                'event_action' => 'resolve',
                'dedup_key'    => 'benecaster-grace-cutoff-' . home_url(),
            ] ),
        ] );

        // Post a human-readable summary to Slack.
        wp_remote_post( MY_SLACK_WEBHOOK_URL, [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
            'body'    => wp_json_encode( [
                'text' => sprintf(
                    ':white_check_mark: Benecaster access restored on %s — %d subscriber%s back after roughly %d hours dark.',
                    home_url(),
                    $restored_count,
                    1 === $restored_count ? '' : 's',
                    $hours
                ),
            ] ),
        ] );
    },
    10,
    2
);
