<?php
// Teaser show notes on the public feed, full notes for supporters

add_filter( 'benecaster_feed_episode_data', function ( array $data, int $episode_id, int $show_id, string $tier_slug ): array {
    if ( 'public' !== $tier_slug ) {
        return $data; // Paying tiers keep the full notes.
    }
    $teaser = wp_trim_words( $data['description'], 40 ) . ' Full notes for supporters.';
    $data['description']     = $teaser;                                  // <description>
    $data['summary']         = $teaser;                                  // <itunes:summary>
    $data['content_encoded'] = '<p>' . esc_html( $teaser ) . '</p>';     // <content:encoded>
    return $data;
}, 10, 4 );
