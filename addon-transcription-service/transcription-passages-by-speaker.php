<?php
// Read a transcript's passages by speaker, with each speaker's guest

// Index each passage under the guest who said it.
add_action( 'my_addon_reindex_episode', function ( int $episode_id ): void {
    $passages = function_exists( 'benecaster_get_episode_transcript_passages' )
        ? benecaster_get_episode_transcript_passages( $episode_id )
        : null;
    if ( null === $passages ) {
        my_addon_forget( $episode_id );
        return;
    }
    foreach ( $passages as $passage ) {
        if ( null !== $passage['guest_id'] ) {
            my_addon_index_quote( $passage['guest_id'], $episode_id, $passage['start'], $passage['text'] );
        }
    }
} );
