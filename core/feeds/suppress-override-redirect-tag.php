<?php
// Suppress or override the feed redirect tag without changing stored settings

// Suppress the redirect tag for the free tier only.
add_filter( 'benecaster_feed_channel_data', function ( array $data, int $show_id ): array {
    // $tier_slug is available via the feed request context stored in the token.
    // For a tier-agnostic override, just clear the key unconditionally.
    $data['new_feed_url'] = '';
    return $data;
}, 10, 2 );
