<?php
// Build a custom follower signup UI

add_action( 'wp_ajax_nopriv_my_follow', 'my_addon_handle_follow' );
add_action( 'wp_ajax_my_follow', 'my_addon_handle_follow' );

function my_addon_handle_follow(): void {
    check_ajax_referer( 'my_addon_follow' );

    $result = benecaster_follower_signup(
        absint( $_POST['show_id'] ?? 0 ),
        sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
        sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
        '',                                    // wall_name — set later from the account page
        (string) ( $_POST['password'] ?? '' )  // ignored if the address already has an account
    );

    if ( is_wp_error( $result ) ) {
        // Safe to show: the messages are deliberately non-enumerating.
        wp_send_json_error( [ 'message' => $result->get_error_message() ], 400 );
    }

    wp_send_json_success( [
        'message' => $result['created']
            ? __( 'Check your inbox for your private feed link.', 'my-addon' )
            : __( "You're all set — we've sent your feed link again.", 'my-addon' ),
    ] );
}
