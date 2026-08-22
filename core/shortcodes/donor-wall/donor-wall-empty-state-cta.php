<?php
// Replace the default empty state with a custom call-to-action linking to checkout.
add_filter( 'benecaster_donor_wall_empty_message', function ( string $html, int $show_id ): string {
    $checkout_url = home_url( '/support-the-show/' );

    return sprintf(
        '<div class="my-theme-donor-wall-empty">'
        . '<h3>%s</h3>'
        . '<p>%s</p>'
        . '<a class="button button-primary" href="%s">%s</a>'
        . '</div>',
        esc_html__( 'Be the first supporter', 'my-theme' ),
        esc_html__( 'Your name lands here the moment your first tip clears.', 'my-theme' ),
        esc_url( $checkout_url ),
        esc_html__( 'Tip the show', 'my-theme' )
    );
}, 10, 2 );
