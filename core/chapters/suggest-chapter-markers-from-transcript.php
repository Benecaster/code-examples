<?php
/**
 * Populate the Auto-suggest chapters button from a custom segmentation source.
 *
 * The chapter editor shows an "Auto-suggest chapters" button when a
 * Transcription Service–style add-on is installed. Clicking it POSTs to
 * /wp-json/benecaster/v1/episodes/{id}/chapters/auto-suggest, which defers to
 * the benecaster_chapter_autosuggest filter. Anything that produces HH:MM:SS +
 * title pairs — an LLM, a Whisper wrapper, a manual import — can hook this
 * filter. Suggestions pre-fill the editor; the podcaster must save manually.
 */
add_filter( 'benecaster_chapter_autosuggest', function ( array $chapters, int $episode_id, WP_Post $post ): array {
    // Return an empty array if you can't produce a suggestion for this episode
    // (missing transcript, upstream API down, etc.) — the endpoint will 501
    // and the UI will display "No chapter suggestions were returned."
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

/**
 * If you also want the UI button to appear, register your add-on slug with
 * benecaster_installed_addons. The React SPA reads the localized list to
 * decide whether to render the Auto-suggest button.
 */
add_filter( 'benecaster_installed_addons', function ( array $slugs ): array {
    $slugs[] = 'benecaster-addon-transcription-service';
    return $slugs;
} );
