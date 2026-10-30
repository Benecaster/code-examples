<?php
// Import a transcript into an episode from your add-on

if ( ! function_exists( 'benecaster_import_episode_transcript' ) ) {
    return; // Transcription Service is not active.
}

// $tag is one <podcast:transcript> from the source feed: [ 'url' => …, 'type' => 'application/x-subrip' ].
$response = wp_safe_remote_get( $tag['url'], [ 'timeout' => 15 ] );
if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
    return;
}

$result = benecaster_import_episode_transcript( $episode_id, wp_remote_retrieve_body( $response ), $tag['type'] );

if ( is_wp_error( $result ) ) {
    // 'benecaster_transcription_import_exists': the episode already has one; leave it.
    // 'benecaster_transcription_import_unsupported': an HTML or Podcasting 2.0 JSON transcript; try the feed's next tag.
    my_addon_report( $episode_id, $result->get_error_message() );
}
