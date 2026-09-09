<?php
// Add your add-on's own paragraph to Benecaster's suggested privacy-policy text

add_filter( 'benecaster_privacy_policy_sections', function ( array $sections ): array {
    // Gate on your OWN add-on's real setting -- never emit unconditionally.
    if ( ! get_option( 'my_addon_transcription_enabled', false ) ) {
        return $sections;
    }

    $sections[] = [
        'heading' => __( 'Episode Transcripts', 'my-addon' ),
        'content' => __( 'When transcription is enabled, we send episode audio to our transcription provider to generate a text transcript, which is stored alongside the episode.', 'my-addon' ),
    ];

    return $sections;
} );
