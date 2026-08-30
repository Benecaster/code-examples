<?php
// Replace the built-in set-your-password email with your own

add_filter( 'benecaster_subscribe_send_password_email', '__return_false' );

add_action( 'benecaster_subscribe_user_created', function ( int $user_id, string $email, int $show_id ): void {
    $user = get_user_by( 'id', $user_id );
    if ( ! $user ) {
        return;
    }
    $key = get_password_reset_key( $user );
    if ( is_wp_error( $key ) ) {
        return;
    }
    $link = add_query_arg(
        [ 'action' => 'rp', 'key' => $key, 'login' => rawurlencode( $user->user_login ) ],
        wp_login_url()
    );
    wp_mail(
        $email,
        __( 'Set your password', 'my-addon' ),
        sprintf( __( "Welcome! Set your password here:\n%s", 'my-addon' ), $link )
    );
}, 10, 3 );
