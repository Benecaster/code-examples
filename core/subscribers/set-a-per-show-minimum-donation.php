<?php
// Set a per-show minimum donation, and refuse a donation your own way

/**
 * A patronage show wants a $25 floor; everything else keeps the site value.
 *
 * @param int $minimum Minor units.
 */
add_filter( 'benecaster_donation_minimum_amount', function ( int $minimum, int $show_id ): int {
    return 42 === $show_id ? 2500 : $minimum;
}, 10, 2 );

/**
 * For anything the amount cannot express, refuse the intent outright.
 * Runs after amount validation and before Stripe is touched.
 */
add_filter( 'benecaster_should_create_donation_intent', function ( bool $create, int $show_id, int $amount, string $currency ): bool {
    return 'USD' === $currency ? $create : false;
}, 10, 4 );
