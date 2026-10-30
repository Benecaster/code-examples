<?php
// Choose which transcript downloads your listeners get

add_filter( 'benecaster_transcript_download_formats', function ( array $formats, int $episode_id ): array {
    $show_id = (int) get_post_field( 'post_parent', $episode_id );

    if ( 12 === $show_id ) {
        return [ 'txt' ];
    }

    return 34 === $show_id ? [] : $formats;
}, 10, 2 );
