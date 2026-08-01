<?php
// Trigger a workflow when a new episode is first created

add_action( 'benecaster_episode_created', function ( int $episode_id, int $show_id ) {
    my_pm_create_task( [
        'name'    => get_the_title( $episode_id ),
        'show_id' => $show_id,
        'wp_id'   => $episode_id,
        'status'  => 'draft',
    ] );
}, 10, 2 );
