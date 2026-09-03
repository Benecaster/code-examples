<?php
/**
 * Replace the built-in set-your-password email with your own
 */

// 1. Turn off the core email so the subscriber gets one message, not two.
add_filter( 'benecaster_subscribe_send_password_email', '__return_false' );

// 2. Send your own in its place.
add_action(
    'benecaster_subscriber_account_provisioned',
    function ( int $user_id, int $show_id, string $source ): void {
        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) {
            return;
        }

        // get_password_reset_key() is what makes the link single-use and
        // expiring. Never email a password you generated yourself.
        $key = get_password_reset_key( $user );
        if ( is_wp_error( $key ) ) {
            return;
        }

        $link = add_query_arg(
            [
                'action' => 'rp',
                'key'    => $key,
                'login'  => rawurlencode( $user->user_login ),
            ],
            wp_login_url()
        );

        $show = get_the_title( $show_id );

        benecaster_mail(
            $show_id,
            $user->user_email,
            sprintf(
                /* translators: %s: show name */
                __( 'Your %s account is ready', 'my-addon' ),
                $show
            ),
            sprintf(
                /* translators: 1: show name, 2: set-password link */
                __( "You have been added to %1\$s.\n\nSet your password here:\n%2\$s", 'my-addon' ),
                $show,
                $link
            )
        );
    },
    10,
    3
);
