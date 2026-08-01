<?php
// Add transcript metadata from a transcription service

add_filter( 'benecaster_podcast_transcripts', function ( array $transcripts, int $episode_id ) {
    $srt_url = get_post_meta( $episode_id, '_my_transcript_srt', true );
    $vtt_url = get_post_meta( $episode_id, '_my_transcript_vtt', true );
    if ( $srt_url ) {
        $transcripts[] = [ 'url' => $srt_url, 'type' => 'application/srt', 'language' => 'en' ];
    }
    if ( $vtt_url ) {
        $transcripts[] = [ 'url' => $vtt_url, 'type' => 'text/vtt', 'language' => 'en' ];
    }
    return $transcripts;
}, 10, 2 );
