<?php
// Keep a restricted transcript private when your add-on is switched off

// Your add-on's main file, outside the entitlement-gated bootstrap.
add_filter( 'benecaster_installed_addons', static function ( array $slugs ): array {
    $slugs[] = 'benecaster-addon-my-transcripts';
    return $slugs;
} );

// Wherever you store a transcript URL.
function my_transcripts_store_url( int $episode_id, string $url, string $mime_type ): void {
    ( new \Benecaster\Episode\EpisodeMeta( $episode_id ) )
        ->set_podcast2_transcript_url( $url )
        ->set_podcast2_transcript_type( $mime_type )
        ->set_podcast2_transcript_owner( '' === $url ? '' : 'benecaster-addon-my-transcripts' );
    if ( '' !== $url ) {
        \Benecaster\Episode\TranscriptUrlSource::announce( $episode_id, $url, $mime_type );
    }
}
