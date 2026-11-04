<?php
// Remove a transcript, and drop what you built from it

add_action( 'benecaster_transcript_updated', function ( int $transcript_id, int $episode_id, string $reason ): void {
    if ( 'deleted' === $reason ) {
        my_index_forget( $transcript_id ); // The row is gone: use the id only as your own key.
    }
}, 10, 3 );
