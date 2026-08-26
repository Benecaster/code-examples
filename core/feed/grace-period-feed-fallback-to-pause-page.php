<?php
// Redirect grace-period feeds to a pause page

// Redirect to a WordPress post explaining the pause. The post can be the
// same for every show or resolved dynamically per show — the filter fires
// with $show_id so a multi-show operator can branch on it.
add_filter( 'benecaster_grace_period_feed_fallback', function ( ?string $public_feed_url, int $show_id ): ?string {
    // Optional: build a per-show URL if you host a status page per show.
    // Falling back to the default public feed URL is fine when the show
    // doesn't have a dedicated explainer — return $public_feed_url to
    // preserve the built-in behavior for those shows.
    $pause_page_id = (int) get_post_meta( $show_id, '_my_show_pause_page_id', true );
    if ( $pause_page_id > 0 ) {
        $url = get_permalink( $pause_page_id );
        if ( is_string( $url ) && '' !== $url ) {
            return $url;
        }
    }

    // No custom page configured — let the default public feed redirect happen.
    return $public_feed_url;
}, 10, 2 );
