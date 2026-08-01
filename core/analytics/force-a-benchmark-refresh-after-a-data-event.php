<?php
// Force the platform benchmark cache to refresh outside the daily cron tick

add_filter( 'benecaster_benchmarks_fetch_skip', function ( bool $skip, string $source ): bool {
    // Freeze the cache on the staging install for snapshot review days,
    // but let the manual "Refresh now" admin button still go through.
    if ( 'cron' === $source && defined( 'BENECASTER_BENCHMARK_FREEZE' ) ) {
        return true;
    }
    return $skip;
}, 10, 2 );

add_action( 'benecaster_benchmarks_refreshed', function ( array $payload ): void {
    // Mirror the just-cached payload into a Slack channel for an at-a-glance daily check.
    if ( empty( $payload['benchmarks']['subscriber_count'] ) ) {
        return;
    }
    wp_remote_post( SLACK_WEBHOOK_URL, [
        'timeout'  => 5,
        'blocking' => false,
        'body'     => wp_json_encode( [ 'text' => 'Benchmarks refreshed — p50: ' . $payload['benchmarks']['subscriber_count']['p50'] ] ),
    ] );
} );
