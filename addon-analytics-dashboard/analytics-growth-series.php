<?php
// Read or extend the Analytics Dashboard growth series

add_filter( 'benecaster_analytics_growth_series', function ( array $data, array $args ): array {
    // Hide a staff-only tier from the chart.
    $data['tiers'] = array_values( array_filter( $data['tiers'], fn( $s ) => 'staff' !== $s['tier_slug'] ) );
    return $data;
}, 10, 2 );
