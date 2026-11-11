<?php
// Run your own code when a show's Content Calendar content types are saved

add_action( 'benecaster_content_calendar_after_save_content_types', function ( array $types, int $show_id ): void {
    update_post_meta( $show_id, '_my_addon_calendar_type_count', count( $types ) );
}, 10, 2 );
