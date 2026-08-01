<?php
// Post-process a multi-tier assembled feed as a whole

add_filter( 'benecaster_feed_xml', function ( string $xml, int $show_id, string|array $tier_arg ): string {
    // Only act on the assembled multi-tier feed.
    if ( ! is_array( $tier_arg ) ) {
        return $xml;
    }

    // Example: insert a custom channel element after <channel>.
    $badge = '<!-- Assembled from tiers: ' . implode( ', ', $tier_arg ) . ' -->';
    return str_replace( '<channel>', '<channel>' . $badge, $xml );
}, 10, 3 );
