<?php
// Give higher tiers a longer window to re-enter payment details

add_filter( 'benecaster_promote_grace_length_days', function ( int $days, array $promotion, int $user_id ): int {
    $extra = [
        'gold'   => 90,
        'silver' => 60,
    ];

    // Annual subscribers get the longest window regardless of tier - they are
    // the least likely to be watching their inbox on any given week.
    if ( 'annual' === ( $promotion['billing_interval'] ?? '' ) ) {
        return max( $days, 120 );
    }

    return $extra[ $promotion['tier_slug'] ] ?? $days;
}, 10, 3 );
