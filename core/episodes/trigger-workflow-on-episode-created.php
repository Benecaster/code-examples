<?php
// Trigger a workflow when a new episode is first created

add_action( 'benecaster_episode_created', function ( int $episode_id, int $show_id ) {
    my_pm_create_task( [
        // get_the_title() returns HTML (Dave&#8217;s Q&#038;A); this is plain text.
        'name'    => html_entity_decode( get_the_title( $episode_id ), ENT_QUOTES, 'UTF-8' ),
        'show_id' => $show_id,
        'wp_id'   => $episode_id,
        'status'  => 'draft',
    ] );
}, 10, 2 );
