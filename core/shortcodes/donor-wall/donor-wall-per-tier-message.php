<?php
// Append a tier-appropriate thank-you message to each donor-wall card.
add_filter( 'benecaster_donor_wall_item', function ( string $html, object $donation, int $show_id ): string {
    $amount = isset( $donation->amount ) ? (float) $donation->amount : 0.0;
    if ( $amount <= 0 ) {
        return $html;
    }

    // Amount thresholds are in major-currency units — adjust or branch on
    // $donation->currency for multi-currency shows.
    if ( $amount >= 100 ) {
        $tier    = 'gold';
        $message = __( 'Legendary tip — thank you!', 'my-theme' );
    } elseif ( $amount >= 25 ) {
        $tier    = 'silver';
        $message = __( 'Amazing support — thank you!', 'my-theme' );
    } elseif ( $amount >= 5 ) {
        $tier    = 'bronze';
        $message = __( 'Thanks for the boost!', 'my-theme' );
    } else {
        return $html;
    }

    $badge = sprintf(
        '<div class="my-theme-donor-wall__tier my-theme-donor-wall__tier--%s">%s</div>',
        esc_attr( $tier ),
        esc_html( $message )
    );

    // Append the tier message inside the item wrapper. The card's built-in
    // markup ends with `</div></div>` (outer div closes the item; inner one
    // closes the header). Anchor on end-of-string so we insert just before
    // the item wrapper's closing tag.
    return (string) preg_replace(
        '#</div>\s*$#',
        $badge . '</div>',
        $html,
        1
    );
}, 10, 3 );
