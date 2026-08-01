<?php
// Send episode notifications via custom webhook on publish

add_action( 'benecaster_episode_published', function ( int $episode_id, int $show_id ) {
    $payload = [
        'episode_id'   => $episode_id,
        'show_id'      => $show_id,
        'title'        => get_the_title( $episode_id ),
        'audio_url'    => get_post_meta( $episode_id, '_benecaster_audio_url', true ),
        'published_at' => get_the_date( 'c', $episode_id ),
    ];

    wp_remote_post( 'https://hooks.example.com/new-episode', [
        'body'    => wp_json_encode( $payload ),
        'headers' => [ 'Content-Type' => 'application/json' ],
        'timeout' => 5,
    ] );
}, 10, 2 );
