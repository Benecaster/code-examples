<?php
// Ping a Slack channel when a cancelled subscriber's app polls a revoked token

add_action( 'benecaster_feed_request_dispatched', function ( array $ctx ): void {
    if ( 'revoked' !== $ctx['token_status'] ) {
        return; // only interested in cancelled subscribers still polling
    }

    $webhook = getenv( 'SLACK_WINBACK_WEBHOOK' );
    if ( ! $webhook ) return;

    wp_remote_post( $webhook, [
        'blocking' => false,
        'body'     => wp_json_encode( [
            'text' => sprintf(
                'Revoked-token poll on show #%d — token %s from %s (%s)',
                $ctx['show_id'],
                $ctx['token_prefix'] ?? 'unknown',
                $ctx['country_code'] ?? '??',
                $ctx['user_agent'] ?? 'unknown UA'
            ),
        ] ),
        'headers'  => [ 'Content-Type' => 'application/json' ],
    ] );
} );
