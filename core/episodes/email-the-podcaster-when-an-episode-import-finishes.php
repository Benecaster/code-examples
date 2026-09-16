<?php
// Email the podcaster when an episode import finishes

add_action( 'benecaster_bulk_import_completed', function ( int $show_id, array $progress, string $job_id, string $feed_url ): void {
    $show = get_the_title( $show_id );

    if ( 'failed' === $progress['status'] ) {
        wp_mail(
            get_option( 'admin_email' ),
            sprintf( 'Episode import for %s failed', $show ),
            sprintf( "The import from %s stopped: %s", $feed_url, $progress['error_msg'] ?? 'unknown error' )
        );
        return;
    }

    wp_mail(
        get_option( 'admin_email' ),
        sprintf( 'Episode import for %s finished', $show ),
        sprintf(
            "%d of %d episodes were imported as drafts (%d were already there, %d could not be created).\nReview them in Benecaster → Episodes.",
            $progress['imported'],
            $progress['total'],
            $progress['skipped'],
            $progress['errors']
        )
    );
}, 10, 4 );
