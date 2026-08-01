<?php
// Add a subscriber to Mailchimp without the built-in integration

add_action(
    'benecaster_token_generated',
    function ( int $token_id, int $user_id, int $show_id, string $tier_slug ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }
        $api_key = defined( 'MY_MAILCHIMP_KEY' ) ? MY_MAILCHIMP_KEY : '';
        $list_id = 'abc123def4';
        $dc      = substr( $api_key, strrpos( $api_key, '-' ) + 1 );
        wp_remote_post(
            "https://{$dc}.api.mailchimp.com/3.0/lists/{$list_id}/members",
            [
                'timeout'  => 5,
                'blocking' => false,
                'headers'  => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'apikey ' . $api_key,
                ],
                'body'     => wp_json_encode( [
                    'email_address' => $user->user_email,
                    'status_if_new' => 'subscribed',
                    'merge_fields'  => [
                        'FNAME' => $user->first_name,
                        'TIER'  => $tier_slug,
                        'SHOW'  => get_the_title( $show_id ),
                    ],
                    'tags' => [ 'benecaster', "show-{$show_id}" ],
                ] ),
            ]
        );
    },
    10,
    4
);
