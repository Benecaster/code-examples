<?php
// Suggest chapter markers from a transcript

add_filter( 'benecaster_chapter_autosuggest', function ( array $chapters, int $episode_id, WP_Post $post ): array {
    // Return an empty array if you can't produce a suggestion for this episode
    // (missing transcript, upstream API down, etc.) — the endpoint will 501.
    $transcript = get_post_meta( $episode_id, '_my_transcript_text', true );
    if ( '' === $transcript ) {
        return $chapters;
    }

    // Do the real work: call your LLM / segmentation service / etc.
    $segments = my_segment_transcript( $transcript );

    return array_map(
        fn( array $s ): array => [
            'timestamp' => $s['hms'],           // 'HH:MM:SS' — malformed rows are dropped
            'title'     => $s['title'],         // sanitized on save
            // Optional fields:
            'url'       => $s['deep_link']  ?? null,
            'image_id'  => $s['image_id']   ?? null,
        ],
        $segments
    );
}, 10, 3 );

// Register your add-on slug so the React SPA renders the Auto-suggest button.
add_filter( 'benecaster_installed_addons', function ( array $slugs ): array {
    $slugs[] = 'benecaster-addon-transcription-service';
    return $slugs;
} );
