<?php
// Alert on the feed request log emergency row-cap guardrail

add_action( 'benecaster_feed_request_log_hard_cap_enforced', function ( array $ctx ): void {
    wp_remote_post( 'https://events.pagerduty.com/v2/enqueue', [
        'blocking' => false,
        'body'     => wp_json_encode( [
            'routing_key'  => getenv( 'PAGERDUTY_KEY' ),
            'event_action' => 'trigger',
            'payload'      => [
                'summary'  => sprintf(
                    'Benecaster feed-request-log guardrail deleted %d rows (was %d, cap %d)',
                    $ctx['deleted'],
                    $ctx['previous_count'],
                    $ctx['cap']
                ),
                'source'   => home_url(),
                'severity' => 'warning',
            ],
        ] ),
        'headers'  => [ 'Content-Type' => 'application/json' ],
    ] );
} );
