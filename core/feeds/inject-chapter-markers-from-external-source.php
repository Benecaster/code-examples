<?php
// Inject chapter markers from an external source

add_filter( 'benecaster_podcast_chapters', function ( array $chapters, int $episode_id ) {
    $chapters_url = get_post_meta( $episode_id, '_my_chapters_url', true );
    if ( ! $chapters_url ) {
        return $chapters;
    }
    return [
        'url'  => $chapters_url,
        'type' => 'application/json+chapters', // Podlove format (default if omitted)
    ];
}, 10, 2 );
