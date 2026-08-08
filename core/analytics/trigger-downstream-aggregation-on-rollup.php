<?php
// Trigger a downstream aggregation job when the nightly rollup completes

add_action( 'benecaster_feed_request_rollup_completed', function ( array $ctx ): void {
    // Only re-aggregate when the primary rollup actually wrote rows.
    if ( 0 === $ctx['rows_written'] ) {
        return;
    }

    // Schedule the downstream job on the immediate action queue so we
    // don't block the cron pass.
    wp_schedule_single_event(
        time() + 60,
        'my_addon_reaggregate_dashboard_metrics',
        [ $ctx['date'] ]
    );
} );
