<?php
// Inject Podlove Simple Chapters inline into the feed

add_filter( 'benecaster_psc_chapters', function ( array $chapters, int $episode_id ) {
    $raw = get_post_meta( $episode_id, '_my_psc_chapters', true );
    if ( ! $raw ) {
        return $chapters;
    }
    // Stored as JSON: [{"start":"00:00:00.000","title":"Intro","href":"https://..."}]
    $decoded = json_decode( $raw, true );
    return is_array( $decoded ) ? $decoded : $chapters;
}, 10, 2 );
