<?php
// Label paid feeds, or give them their own artwork, in the listener's podcast app

add_filter( 'benecaster_feed_channel_data', function ( array $data, int $show_id, string $tier_slug ): array {
    if ( 'public' === $tier_slug ) {
        return $data;
    }
    $data['title']  .= ' (Premium)';                                     // <title> and <itunes:title>
    $data['artwork'] = 'https://cdn.example.com/premium-artwork.jpg';    // <image> and <itunes:image>
    return $data;
}, 10, 3 );
