<?php
// Queue a "Set your password" email when a logged-out visitor signs up

add_action( 'benecaster_subscribe_user_created', function ( int $user_id, string $email ): void {
    $user = get_user_by( 'id', $user_id );
    if ( ! $user ) {
        return;
    }
    $key  = get_password_reset_key( $user );
    $link = add_query_arg(
        [ 'action' => 'rp', 'key' => $key, 'login' => rawurlencode( $user->user_login ) ],
        wp_login_url()
    );
    wp_mail(
        $email,
        __( 'Set your password', 'my-addon' ),
        sprintf( __( "Welcome! Set your password here:\n%s", 'my-addon' ), $link )
    );
}, 10, 2 );
