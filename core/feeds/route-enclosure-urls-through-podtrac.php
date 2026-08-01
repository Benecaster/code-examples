<?php
// Route all enclosure URLs through Podtrac

add_filter(
    'benecaster_feed_enclosure_url',
    function ( string $url, int $episode_id, int $show_id, ?string $tier_slug ): string {
        if ( '' === $url ) {
            return $url;
        }
        $parts = wp_parse_url( $url );
        if ( ! is_array( $parts ) || empty( $parts['host'] ) ) {
            return $url;
        }
        $host_and_path = $parts['host'] . ( $parts['path'] ?? '' );
        return 'https://dts.podtrac.com/redirect.mp3/' . $host_and_path;
    },
    10,
    4
);
