<?php
// Swap the audio enclosure URL per subscriber tier at feed compile time

add_filter(
    'benecaster_episode_audio_url',
    function ( string $url, int $episode_id, string $tier_slug ): string {
        // Route paid tiers through a signed-URL CDN; leave the public/free feed alone.
        if ( in_array( $tier_slug, [ 'public', 'free' ], true ) ) {
            return $url;
        }
        return my_addon_sign_cdn_url( $url, [ 'ttl' => 900 ] );
    },
    10,
    3
);
