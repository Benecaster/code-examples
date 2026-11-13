<?php
// Read or change an episode's production plan, change how a new plan starts, and run code when a plan is finalised

// Add a one-off task to every plan started on show 12.
add_filter( 'benecaster_podcast_workflow_plan_from_preset', function ( array $tasks, int $episode_id, int $show_id ): array {
    if ( 12 === $show_id ) {
        $tasks[] = [ 'id' => 'my-plugin-legal-check', 'name' => 'Legal check', 'offset_days' => -3, 'duration_days' => 1, 'preset_id' => '' ];
    }
    return $tasks;
}, 10, 3 );

add_action( 'benecaster_podcast_workflow_after_finalise_plan', function ( int $episode_id, bool $finalised, int $show_id ): void {
    if ( $finalised ) {
        my_plugin_post_to_team_chat( $episode_id );
    }
}, 10, 3 );
