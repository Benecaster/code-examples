<?php
// Turn the video preview off, or serve your own clip

// Every episode of show 12 previews the same trailer.
add_filter( 'benecaster_episode_preview_video', function ( array $preview, int $episode_id, int $show_id ): array {
    if ( 12 !== $show_id ) {
        return $preview;
    }
    return [ 'source' => 'file', 'url' => 'https://cdn.example.com/trailer.mp4', 'start' => 0, 'end' => 0 ];
}, 10, 3 );
