<?php
// React when a new membership tier is detected without a Benecaster mapping

add_action( 'benecaster_tier_unmapped', function ( $tier_id, string $plugin_slug ): void {
    $message = sprintf(
        'New %s tier (ID: %s) detected — no Benecaster mapping found. Visit Benecaster settings to map it.',
        $plugin_slug,
        $tier_id
    );
    wp_remote_post( MY_SLACK_WEBHOOK_URL, [
        'body'    => wp_json_encode( [ 'text' => $message ] ),
        'headers' => [ 'Content-Type' => 'application/json' ],
    ] );
}, 10, 2 );
