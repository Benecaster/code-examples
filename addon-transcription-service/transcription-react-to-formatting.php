<?php
// React when a transcript is formatted

add_action( 'benecaster_transcript_formatted', function ( int $transcript_id, int $episode_id ): void {
    // The episode page now shows the formatted paragraphs: drop its cached copy.
    if ( function_exists( 'my_cache_purge_url' ) ) {
        my_cache_purge_url( get_permalink( $episode_id ) );
    }
}, 10, 2 );
