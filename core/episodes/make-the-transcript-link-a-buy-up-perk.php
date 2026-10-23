<?php
// Make the transcript a buy-up perk, on the website and in the feed

// The website link.
add_filter( 'benecaster_show_episode_transcript', function ( bool $show, int $episode_id, ?int $user_id ): bool {
    $my_transcripts_buyup_id = 12; // Memberships → Buy-ups → your "Transcripts" buy-up.
    return $show && $user_id && benecaster_user_has_buyup( $user_id, $my_transcripts_buyup_id, (int) wp_get_post_parent_id( $episode_id ) );
}, 10, 3 );

// The feed tag. Four accepted args, or $context never arrives.
add_filter( 'benecaster_feed_podcast_episode_tags', function ( array $tags, int $episode_id, int $show_id, array $context ): array {
    $my_transcripts_buyup_id = 12; // The same buy-up as above.
    $slug = benecaster_get_buyup_slug( $my_transcripts_buyup_id, $show_id );
    if ( null === $slug || ! in_array( $slug, $context['listener_slugs'], true ) ) {
        unset( $tags['transcript'] );
    }
    return $tags;
}, 10, 4 );
