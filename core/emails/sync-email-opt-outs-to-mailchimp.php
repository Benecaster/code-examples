<?php
// Sync email opt-outs to Mailchimp

const MY_MIRRORED_LEVELS = [ 'broadcast', 'all' ];

add_action( 'benecaster_email_unsubscribed', function ( ?int $user_id, int $show_id, string $type ): void {
    // $user_id is null for a one-click unsubscribe by someone not logged in.
    if ( null === $user_id || ! in_array( $type, MY_MIRRORED_LEVELS, true ) ) {
        return;
    }
    my_mailchimp_update_status( $user_id, 'unsubscribed' );
}, 10, 3 );

add_action( 'benecaster_email_resubscribed', function ( ?int $user_id, int $show_id, string $type ): void {
    if ( null === $user_id || ! in_array( $type, MY_MIRRORED_LEVELS, true ) ) {
        return;
    }
    // A listener opted out at both levels who clears one is still opted out at the other.
    // If that matters for your list, track both levels from these two hooks first.
    my_mailchimp_update_status( $user_id, 'subscribed' );
}, 10, 3 );

function my_mailchimp_update_status( int $user_id, string $status ): void {
    $user = get_userdata( $user_id );
    if ( ! $user instanceof WP_User ) {
        return;
    }
    $hash = md5( strtolower( $user->user_email ) );
    wp_remote_request( 'https://us1.api.mailchimp.com/3.0/lists/YOUR_LIST/members/' . $hash, [
        'method'   => 'PATCH',
        'timeout'  => 5,
        'blocking' => false,
        'headers'  => [
            'Authorization' => 'Basic ' . base64_encode( 'anystring:' . MY_MAILCHIMP_API_KEY ),
            'Content-Type'  => 'application/json',
        ],
        'body'     => wp_json_encode( [ 'status' => $status ] ),
    ] );
}
