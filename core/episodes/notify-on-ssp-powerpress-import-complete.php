<?php
// Send a Slack notification when an SSP or PowerPress import finishes and new drafts were created

function my_import_done_notify( int $show_id, int $imported, int $skipped ): void {
    if ( 0 === $imported ) {
        return;
    }
    my_slack()->send( sprintf(
        'Import complete for show #%d: %d new drafts, %d skipped.',
        $show_id, $imported, $skipped
    ) );
}
add_action( 'benecaster_ssp_import_after',        'my_import_done_notify', 10, 3 );
add_action( 'benecaster_powerpress_import_after', 'my_import_done_notify', 10, 3 );
