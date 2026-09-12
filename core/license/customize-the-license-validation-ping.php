<?php
// Customize the License Validation Ping

add_filter( 'benecaster_telemetry_payload', function ( array $payload ): array {
    // Does not error, but has no effect either — the license server
    // only records fields it already knows about, so an unrecognized
    // key like this one is simply dropped on arrival.
    $payload['my_addon_active_workflows'] = my_addon_count_active_workflows();

    // This is the case the filter is actually useful for: removing a
    // non-enforcement key you don't want sent.
    unset( $payload['telemetry']['web_player_plays'] );

    // NOT safe — this line has no effect. subscriber_count is restored
    // to its real value right after this filter returns.
    $payload['subscriber_count'] = 0;

    return $payload;
} );
