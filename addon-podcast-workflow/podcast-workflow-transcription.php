<?php
// Read an episode's Transcription tile, save its notes, and run code when they are saved

add_action( 'benecaster_podcast_workflow_after_save_transcription_notes', function ( int $episode_id, bool $done, string $notes, int $show_id ): void {
    if ( $done ) {
        my_plugin_attach_external_transcript( $episode_id );
    }
}, 10, 4 );
