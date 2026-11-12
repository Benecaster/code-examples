<?php
// Run your own code when an episode's workflow status, recording or outline changes in Podcast Workflow

add_action( 'benecaster_podcast_workflow_after_status_change', function ( int $episode_id, string $new, string $old, int $show_id ): void {
    if ( 'approved' === $new ) {
        my_plugin_tell_the_editor( $episode_id ); // e.g. post to the team's chat
    }
}, 10, 4 );
