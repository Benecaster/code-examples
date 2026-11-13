<?php
// Read or save an episode's Guest preparation, and run code when it is saved

// Tell the host when a guest is ready.
add_action( 'benecaster_podcast_workflow_after_save_guest_preparation', function ( int $episode_id, bool $prepared, string $notes, int $show_id ): void {
    if ( $prepared ) {
        my_plugin_notify_host( $episode_id );
    }
}, 10, 4 );
