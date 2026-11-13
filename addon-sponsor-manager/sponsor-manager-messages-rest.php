<?php
// Read or write a show's sponsor messages from code, as the Sponsors screen's Messages tab does

// Log every change to a show's sponsor copy for the ad-sales team.
add_action( 'benecaster_sponsor_manager_after_save_message', function ( int $message_id, int $show_id, array $fields, bool $created ): void {
    if ( array_key_exists( 'body', $fields ) ) {
        my_sales_log( $show_id, $message_id, $created ? 'created' : 'copy changed' );
    }
}, 10, 4 );
