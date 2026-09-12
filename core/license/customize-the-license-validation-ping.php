<?php
// Customize the License Validation Ping

add_filter( 'benecaster_telemetry_payload', function ( array $payload ): array {
    // Safe: a new custom key nothing else reads.
    $payload['my_addon_active_workflows'] = my_addon_count_active_workflows();

    // Also safe: removing a non-enforcement key you don't want sent.
    unset( $payload['telemetry']['web_player_plays'] );

    // NOT safe — this line has no effect. subscriber_count is restored
    // to its real value right after this filter returns.
    $payload['subscriber_count'] = 0;

    return $payload;
} );
