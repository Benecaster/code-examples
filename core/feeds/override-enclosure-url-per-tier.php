<?php
// Swap the audio enclosure URL per subscriber tier at feed compile time

add_filter(
    'benecaster_episode_audio_url',
    function ( string $url, int $episode_id, ?string $tier_slug = null ): string {
        // Web player call — no tier in scope, leave it alone.
        if ( null === $tier_slug ) {
            return $url;
        }
        // Feed and tracked-download calls: route paid tiers through a signed-URL CDN;
        // leave the public/free audio alone.
        if ( in_array( $tier_slug, [ 'public', 'free' ], true ) ) {
            return $url;
        }
        return my_addon_sign_cdn_url( $url, [ 'ttl' => 900 ] );
    },
    10,
    3
);
