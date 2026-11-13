<?php
// Read and set the status of a task in an episode's production plan, and run code when one changes

add_action( 'benecaster_podcast_workflow_after_task_status_change', function ( int $episode_id, string $task_id, string $new_status, string $old_status, int $show_id ): void {
    if ( 'blocked' === $new_status ) {
        my_plugin_alert_producer( $episode_id, $task_id );
    }
}, 10, 5 );
