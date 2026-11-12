<?php
// Read or change which Workbench tiles a show draws, and run code when a show saves its choice

add_action( 'benecaster_podcast_workflow_after_save_tile_settings', function ( int $show_id, array $tiles ): void {
    if ( false === ( $tiles['chapter-markers'] ?? null ) ) {
        my_plugin_stop_suggesting_chapters( $show_id );
    }
}, 10, 2 );
