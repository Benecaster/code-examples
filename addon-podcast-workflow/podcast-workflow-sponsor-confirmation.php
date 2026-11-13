<?php
// Read or save an episode's Sponsor confirmation notes, and run code when they are saved

add_action( 'benecaster_podcast_workflow_after_save_sponsor_confirmation', function ( int $episode_id, bool $confirmed, string $notes, int $show_id ): void {
    if ( $confirmed ) {
        my_plugin_book_ad_slots( $episode_id, $notes );
    }
}, 10, 4 );
