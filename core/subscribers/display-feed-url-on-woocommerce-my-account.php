<?php
// Display subscriber feed URL on WooCommerce My Account page

add_action( 'woocommerce_account_dashboard', function () {
    $user_id = get_current_user_id();
    if ( $user_id <= 0 ) {
        return;
    }
    $tokens = ( new \Benecaster\Token\TokenRepository() )->find_active_by_user( $user_id );
    if ( empty( $tokens ) ) {
        return;
    }
    echo '<h3>' . esc_html__( 'Your podcast feed', 'my-addon' ) . '</h3>';
    foreach ( $tokens as $token ) {
        $show_id  = (int) $token->show_id;
        $feed_url = benecaster_get_feed_url( $user_id, $show_id );
        printf(
            '<p><strong>%s:</strong> <code>%s</code></p>',
            esc_html( get_the_title( $show_id ) ),
            esc_html( $feed_url )
        );
    }
} );
