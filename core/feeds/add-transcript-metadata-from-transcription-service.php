<?php
// Add transcript metadata from a transcription service

add_filter( 'benecaster_feed_podcast_episode_tags', function ( array $tags, int $episode_id, int $show_id ): array {
    $srt_url = get_post_meta( $episode_id, '_my_transcript_srt', true );
    $vtt_url = get_post_meta( $episode_id, '_my_transcript_vtt', true );
    if ( ! $srt_url && ! $vtt_url ) {
        return $tags;
    }

    // Benecaster pre-fills one entry from the episode's Transcript field. Make it a list
    // before adding to it: appending to a single entry is read as that one entry.
    $current = $tags['transcript'] ?? [];
    $list    = isset( $current['url'] ) ? [ $current ] : (array) $current;

    if ( $srt_url ) {
        $list[] = [ 'url' => $srt_url, 'type' => 'application/srt', 'language' => 'en' ];
    }
    if ( $vtt_url ) {
        $list[] = [ 'url' => $vtt_url, 'type' => 'text/vtt', 'language' => 'en' ];
    }

    $tags['transcript'] = $list;
    return $tags;
}, 10, 3 );
