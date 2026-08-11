<?php
// Push donation-enrolled followers to an external newsletter platform

add_action( 'benecaster_donor_enrolled_as_follower', function ( int $user_id, int $show_id, string $donation_reference ): void {
    $user = get_userdata( $user_id );
    if ( ! $user instanceof \WP_User ) {
        return;
    }

    $api_key = getenv( 'CONVERTKIT_API_KEY' );
    $form_id = getenv( 'CONVERTKIT_FORM_ID' );
    if ( ! $api_key || ! $form_id ) {
        return;
    }

    wp_remote_post(
        'https://api.convertkit.com/v3/forms/' . rawurlencode( $form_id ) . '/subscribe',
        [
            'blocking' => false, // don't stall the webhook response
            'body'     => wp_json_encode( [
                'api_key'    => $api_key,
                'email'      => $user->user_email,
                'first_name' => $user->first_name ?: $user->display_name,
                'tags'       => [ 'benecaster-donor', 'show-' . $show_id ],
                'fields'     => [
                    'benecaster_donation_reference' => $donation_reference,
                    'benecaster_show_id'            => (string) $show_id,
                ],
            ] ),
            'headers'  => [ 'Content-Type' => 'application/json' ],
        ]
    );
}, 10, 3 );
