<?php
// Show transcript-derived results only to people who may see the transcript

$results = array_filter(
    $results, // each with an episode_id, from your own transcript index
    static function ( array $hit ): bool {
        if ( ! function_exists( 'benecaster_user_can_see_transcript' ) ) {
            return false; // No Transcription Service: no transcript text should be in your index either.
        }
        return benecaster_user_can_see_transcript( (int) $hit['episode_id'] ); // the current visitor
    }
);
