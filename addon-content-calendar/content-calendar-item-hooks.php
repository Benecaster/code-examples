<?php
// Run your own code when a Content Calendar content item is saved or deleted

add_action( 'benecaster_content_calendar_after_save_item', function ( array $item, string $context ): void {
    if ( 'posted' === $item['status'] && 'tweet' === $item['type'] ) {
        my_social_log( $item['show_id'], $item['title'], $item['reference_url'] );
    }
}, 10, 2 );
