<?php
// Alert PagerDuty When Feeds Go Dark at Day 30

add_action(
    'benecaster_license_payment_grace_hard_cutoff',
    function ( int $cutoff_at, int $token_count ): void {
        wp_remote_post( 'https://events.pagerduty.com/v2/enqueue', [
            'headers' => [ 'Content-Type' => 'application/json' ],
            'timeout' => 5,
            'body'    => wp_json_encode( [
                'routing_key'  => MY_PAGERDUTY_ROUTING_KEY,
                'event_action' => 'trigger',
                // Stable key so the recovery handler can resolve this exact incident.
                'dedup_key'    => 'benecaster-grace-cutoff-' . home_url(),
                'payload'      => [
                    'summary'  => sprintf(
                        'Benecaster feeds dark — %d subscriber%s lost access (%s)',
                        $token_count,
                        1 === $token_count ? '' : 's',
                        home_url()
                    ),
                    'severity' => 'critical',
                    'source'   => home_url(),
                    'timestamp' => gmdate( 'c', $cutoff_at ),
                    'custom_details' => [
                        'tokens_revoked' => $token_count,
                        'cause'          => 'Benecaster license payment unresolved for 30 days',
                        'remedy'         => 'Update payment at benecaster.com — access restores automatically',
                    ],
                ],
            ] ),
        ] );
    },
    10,
    2
);
