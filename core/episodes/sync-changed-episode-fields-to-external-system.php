<?php
// Sync changed episode fields to an external system

add_action( 'benecaster_episode_updated', function ( int $episode_id, int $show_id, array $changed_fields ) {
    if ( empty( $changed_fields ) ) {
        return; // Meta-only update; skip.
    }

    $payload = [ 'episode_id' => $episode_id, 'changed' => $changed_fields ];

    if ( in_array( 'title', $changed_fields, true ) ) {
        $payload['title'] = get_the_title( $episode_id );
    }
    if ( in_array( 'post_status', $changed_fields, true ) ) {
        $payload['status'] = get_post_status( $episode_id );
    }

    wp_remote_post( 'https://api.example.com/episodes/sync', [
        'body'    => wp_json_encode( $payload ),
        'headers' => [ 'Content-Type' => 'application/json' ],
        'timeout' => 5,
    ] );
}, 10, 3 );
