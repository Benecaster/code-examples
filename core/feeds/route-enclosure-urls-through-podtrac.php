<?php
// Count feed downloads with Podtrac, OP3 or Podscribe

add_filter( 'benecaster_feed_enclosure_url', function (
    string $url,
    int    $episode_id,
    int    $show_id,
    string $tier_slug
): string {
    $outer = 'https://op3.dev/e/';
    if ( '' === $url || str_starts_with( $url, $outer ) ) {
        return $url;
    }
    // Never wrap the download proxy URL: it carries the subscriber's feed token.
    if ( str_starts_with( $url, home_url( '/benecaster-download/' ) ) ) {
        return $url;
    }
    return $outer . preg_replace( '#^https://#i', '', $url );
}, 20, 4 );
