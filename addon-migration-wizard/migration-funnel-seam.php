<?php
// Read a show's migration funnel from PHP, including on cron

if ( ! function_exists( 'benecaster_migration_get_funnel' ) ) {
    return; // The Migration Wizard is not installed on this site.
}

foreach ( benecaster_migration_get_funnel( $show_id ) as $batch ) {
    // $batch['totalImported'], ['totalCompleted'], ['totalDropped'], ['totalPending'],
    // ['gracePeriodDays'], ['graceEndsAt'], ['status'], ['recordsFreeTiers'],
    // ['id'], ['sourcePlatform'], ['importDate']
}
