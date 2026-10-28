<?php
// Read an episode's transcript, and react when it changes

add_action( 'benecaster_transcript_updated', function ( int $transcript_id, int $episode_id, string $reason ): void {
    // Slow work goes to the background; this runs inside the job that changed the text.
    as_enqueue_async_action( 'my_addon_reindex_episode', [ $episode_id ], 'my-addon' );
}, 10, 3 );

add_action( 'my_addon_reindex_episode', function ( int $episode_id ): void {
    $text = function_exists( 'benecaster_get_episode_transcript_text' )
        ? benecaster_get_episode_transcript_text( $episode_id )
        : null;
    null === $text ? my_addon_forget( $episode_id ) : my_addon_index( $episode_id, $text );
} );
