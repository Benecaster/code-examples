<?php
// Know when Sponsor Manager clears a show's feed, and how its tag reaches the feed and Episode Credits

// Purge a CDN's copy of the show's feed whenever Sponsor Manager (or anything) clears it.
add_action( 'benecaster_clear_feed_cache', function ( $show_id = null ): void {
    if ( $show_id ) {
        my_cdn_purge( benecaster_get_public_feed_url( (int) $show_id ) );
    }
}, 20 );
