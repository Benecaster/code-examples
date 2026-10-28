<?php
// Read the Analytics Dashboard feed engagement buckets

// A weekly-active percentage for one tier, the way the weekly digest reads it.
add_filter( 'benecaster_analytics_feed_engagement', function ( array $data, array $args ): array {
    foreach ( $data['tiers'] as &$tier ) {
        $tier['active_7d_pct'] = $tier['total'] > 0 ? round( $tier['active_7d'] * 100 / $tier['total'], 1 ) : null;
    }
    return $data;
}, 10, 2 );
