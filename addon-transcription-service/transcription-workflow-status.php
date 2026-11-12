<?php
// Show an episode's transcription status, and request one, from your add-on

if ( ! function_exists( 'benecaster_transcription_status' ) ) {
    return; // Transcription Service is not active: hide the tile.
}

$status = benecaster_transcription_status( $episode_id ); // Base audio. null: not an episode.
if ( null === $status ) {
    return;
}

$label = match ( $status['status'] ) {
    'none'                  => __( 'Not started', 'my-addon' ),
    'pending', 'processing' => __( 'Processing', 'my-addon' ),
    'complete'              => __( 'Complete', 'my-addon' ),
    'failed'                => __( 'Failed', 'my-addon' ),
    default                 => '',
};
// $status['updated_at'] is UTC: wp_date( 'j M Y H:i', strtotime( $status['updated_at'] . ' UTC' ) ).
// 'complete' → link "View transcript" to $status['editor_url'] (empty while Transcription is off for the show).
// $status['can_request'] → offer "Request transcription"; on the podcaster's confirmed click:

if ( current_user_can( 'manage_options' ) && $status['can_request'] ) {
    $result = benecaster_request_episode_transcription( $episode_id );
    if ( is_wp_error( $result ) ) {
        my_addon_notice( $result->get_error_message() ); // e.g. no provider connected.
    }
}
