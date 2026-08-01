<?php
// Post a webhook to an external monitoring service after every sync with full result data

add_action( 'benecaster_feed_sync_completed', function( array $result ): void {
    if ( 'failed' === $result['status'] ) {
        // Alert on failures.
        my_monitoring_service()->alert( $result['error_message'], $result['feed_url'] );
        return;
    }
    if ( $result['drafts_created'] > 0 ) {
        my_monitoring_service()->info(
            "Feed sync created {$result['drafts_created']} drafts for show {$result['show_id']}."
        );
    }
} );
