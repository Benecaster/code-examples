<?php
// Register a custom export sheet from an add-on

// Analytics Dashboard add-on: export the nightly snapshot table.
add_action( 'benecaster_boot', function (): void {
    if ( ! benecaster_addon_is_active( 'analytics-dashboard' ) ) {
        return;
    }

    // 1. Declare the sheet so it appears in the UI and the file writer.
    add_filter( 'benecaster_export_sheets', function ( array $sheets, array $context ): array {
        $sheets[] = [
            'id'          => 'analytics_daily_snapshots',
            'title'       => __( 'Daily Snapshots', 'analytics-dashboard' ),
            'description' => __( 'Per-tier subscriber, churn, and feed-poll counts for each day in the date range.', 'analytics-dashboard' ),
            'columns'     => [
                'snapshot_date'        => __( 'Date', 'analytics-dashboard' ),
                'tier_slug'            => __( 'Tier slug', 'analytics-dashboard' ),
                'subscriber_count'     => __( 'Subscribers (end of day)', 'analytics-dashboard' ),
                'new_count'            => __( 'Joined', 'analytics-dashboard' ),
                'churn_count'          => __( 'Churned', 'analytics-dashboard' ),
                'total_feed_polls'     => __( 'Feed polls', 'analytics-dashboard' ),
                'unique_active_tokens' => __( 'Active tokens', 'analytics-dashboard' ),
            ],
            'add_on'      => 'analytics-dashboard',
        ];
        return $sheets;
    }, 10, 2 );

    // 2. Supply rows at file-generation time.
    add_filter( 'benecaster_export_sheet_rows_analytics_daily_snapshots', function ( array $rows, array $context ): array {
        // Rows come from storage your add-on owns, narrowed to the requested range and
        // ordered by date then tier. Query only what you control — Benecaster's own
        // storage is internal and can change in any release.
        $results = my_addon_get_daily_snapshots(
            $context['date_start'] ?? null,
            $context['date_end'] ?? null
        );

        foreach ( (array) $results as $row ) {
            $rows[] = [
                (string) $row['snapshot_date'],
                (string) $row['tier_slug'],
                (int) $row['subscriber_count'],
                (int) $row['new_count'],
                (int) $row['churn_count'],
                (int) $row['total_feed_polls'],
                (int) $row['unique_active_tokens'],
            ];
        }
        return $rows;
    }, 10, 2 );
} );
