<?php
// React when a transcript is imported

add_action( 'benecaster_transcript_imported', function ( int $transcript_id, int $episode_id, string $format, string $source ): void {
    // $format: 'srt', 'vtt', 'txt' (no timestamps) or 'json' (Whisper JSON).
    // $source: 'file', 'paste' or 'rss_feed'.
    if ( 'rss_feed' === $source ) {
        update_post_meta( $episode_id, '_my_addon_transcript_carried_over', 1 );
    }
}, 10, 4 );
