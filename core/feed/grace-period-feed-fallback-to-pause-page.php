<?php
// Redirect grace-period feeds to a pause page

// Send subscribers of a paused show to an explainer page rather than
// letting their podcast app report a bare error. Resolve it per show so a
// multi-show operator can point each show somewhere different.
add_filter( 'benecaster_grace_period_feed_fallback', function ( ?string $target, int $show_id ): ?string {
    $pause_page_id = (int) get_post_meta( $show_id, '_my_show_pause_page_id', true );
    if ( $pause_page_id > 0 ) {
        $url = get_permalink( $pause_page_id );
        if ( is_string( $url ) && '' !== $url ) {
            return $url;
        }
    }

    // No explainer configured for this show — return the value you were
    // given rather than inventing one, and the feed goes dark as designed.
    return $target;
}, 10, 2 );
