<?php
// Change the text of the subscribe button

add_filter( 'benecaster_subscribe_button_label', function ( string $label, ?array $price, int $show_id, string $tier_slug ): string {
    if ( null === $price ) {
        return __( 'Follow for free', 'my-theme' ); // Free tiers have no price.
    }
    if ( 'patron' !== $tier_slug ) {
        return $label;
    }
    $period = 'year' === $price['interval_unit']
        ? __( 'Become a Patron for the year', 'my-theme' )
        : __( 'Become a Patron', 'my-theme' );
    return sprintf( '%1$s — $%2$s', $period, number_format_i18n( $price['amount_cents'] / 100, 2 ) );
}, 10, 4 );
