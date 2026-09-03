<?php
// Pause or monitor scheduled analytics data pruning

add_filter( 'benecaster_analytics_prune_skip', function (
    bool   $skip,
    string $source,
    int    $retention_days,
    array  $tables
): bool {
    if ( get_transient( 'my_backup_in_progress' ) ) {
        error_log( 'Benecaster analytics prune skipped: backup in progress.' );
        return true;
    }
    return $skip;
}, 10, 4 );

add_action( 'benecaster_before_analytics_prune', function (
    string $source,
    int    $retention_days,
    array  $tables
) {
    error_log( sprintf(
        'Benecaster analytics prune starting. Source: %s. Retention: %d days. Tables: %s',
        $source,
        $retention_days,
        implode( ', ', $tables )
    ) );
}, 10, 3 );

add_action( 'benecaster_after_analytics_prune', function (
    string $source,
    array  $result
) {
    $total_deleted = array_sum( $result['tables'] );
    error_log( sprintf(
        'Benecaster analytics prune complete. Source: %s. Rows deleted: %d. Time: %dms.',
        $source,
        $total_deleted,
        $result['elapsed_ms']
    ) );

    if ( $total_deleted > 100_000 ) {
        // Plain wp_mail() is deliberate: this is an operator alert to the site's own
        // admin address, where WordPress's own sender identity is correct and expected.
        // Use benecaster_mail() instead for anything a podcaster or subscriber reads.
        wp_mail(
            get_option( 'admin_email' ),
            'Large Benecaster analytics prune completed',
            sprintf( '%d rows were deleted (%dms). Review your retention settings.', $total_deleted, $result['elapsed_ms'] )
        );
    }
}, 10, 2 );
