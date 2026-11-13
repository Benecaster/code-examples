<?php
// Read or change a show's preset task list, and run code when a show saves it

add_action( 'benecaster_podcast_workflow_after_save_preset_tasks', function ( int $show_id, array $tasks ): void {
    $longest = max( array_column( $tasks, 'duration_days' ) ?: [ 0 ] );
    update_post_meta( $show_id, '_my_plugin_longest_task', $longest );
}, 10, 2 );
