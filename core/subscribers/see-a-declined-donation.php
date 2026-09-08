<?php
// See a declined donation, and tune the decline-rate alert

/**
 * @param string $decline_code Stripe's `decline_code` when present
 *                             (`stolen_card`, `insufficient_funds`, ...),
 *                             otherwise its generic `code`, else ''.
 */
add_action( 'benecaster_donation_payment_failed', function ( int $show_id, string $intent_id, string $decline_code ): void {
    if ( in_array( $decline_code, [ 'stolen_card', 'lost_card', 'pickup_card' ], true ) ) {
        error_log( "benecaster: hostile decline on show {$show_id} ({$decline_code})" );
    }
}, 10, 3 );

add_filter( 'benecaster_donation_decline_alert_thresholds', function ( array $thresholds, int $show_id ): array {
    // A high-traffic show can afford to alert sooner.
    return 42 === $show_id
        ? [ 'min_attempts' => 25, 'rate' => 0.25 ]
        : $thresholds;
}, 10, 2 );
