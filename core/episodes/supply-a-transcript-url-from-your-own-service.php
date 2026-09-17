// Supply a transcript URL from your own service

<?php
add_filter(
    'benecaster_podcast2_transcript_autodetect',
    function ( ?string $url, int $episode_id ): ?string {
        // Let core's media-library detection win when it found something.
        if ( null !== $url ) {
            return $url;
        }

        $external_id = get_post_meta( $episode_id, '_my_service_transcript_id', true );
        if ( '' === $external_id ) {
            return null; // Nothing to offer — leave the field empty.
        }

        // Keep the extension: it is what sets the transcript type.
        return 'https://transcripts.example.com/' . rawurlencode( (string) $external_id ) . '.vtt';
    },
    10,
    2
);
