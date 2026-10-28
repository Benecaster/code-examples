<?php
// Read the Analytics Dashboard downloads by tier, by podcast app and by episode

// Leave a staff-only tier out of every panel, export and digest.
add_filter( 'benecaster_analytics_downloads', function ( array $data, array $args ): array {
    $data['tiers'] = array_values( array_filter( $data['tiers'], fn( $t ) => 'staff' !== $t['tier_slug'] ) );
    return $data;
}, 10, 2 );
