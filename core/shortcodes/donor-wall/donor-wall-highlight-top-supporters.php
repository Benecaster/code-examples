<?php
// Highlight Top Supporters on the Donor Wall

add_filter( 'benecaster_donor_wall_item', function ( string $html, object $donation, int $show_id ): string {
    $threshold = 100.00; // major-currency units — e.g. $100 USD, ¥100 JPY.
    $amount    = isset( $donation->amount ) ? (float) $donation->amount : 0.0;

    if ( $amount < $threshold ) {
        return $html;
    }

    $badge = '<span class="my-theme-top-supporter-badge" aria-label="' . esc_attr__( 'Top supporter', 'my-theme' ) . '">★</span>';

    // Inject the badge inside the header div so it sits alongside the name.
    return str_replace(
        '<div class="benecaster-donor-wall__header">',
        '<div class="benecaster-donor-wall__header">' . $badge,
        $html
    );
}, 10, 3 );
