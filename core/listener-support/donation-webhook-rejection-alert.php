<?php
// POST a Slack Alert on Donation Webhook Signature Failure

add_action( 'benecaster_donation_webhook_rejected', function ( string $canonical_platform, string $raw_platform ): void {
    wp_remote_post( 'https://hooks.slack.com/services/T00/B00/xxx', [
        'timeout'  => 3,
        'blocking' => false,
        'headers'  => [ 'Content-Type' => 'application/json' ],
        'body'     => wp_json_encode( [
            'text' => sprintf(
                ':warning: Benecaster donation webhook rejected — platform=%s (raw=%s). Verify the secret in Settings → Listener Support → Webhooks matches the sender.',
                $canonical_platform,
                $raw_platform
            ),
        ] ),
    ] );
}, 10, 2 );

// Optional — fire an "all clear" heartbeat when verification succeeds
// again, so the on-call knows the incident closed itself.
add_action( 'benecaster_donation_webhook_verified', function ( string $canonical_platform ): void {
    set_transient( 'my_webhook_last_verified_' . $canonical_platform, time(), DAY_IN_SECONDS );
} );
