<?php
// React to a Listener Support Donation Reference Being Logged

add_action(
    'benecaster_listener_support_donation_logged',
    function ( int $donation_id, int $show_id, ?int $user_id ): void {
        $repo = benecaster()->container()->make( \Benecaster\ListenerSupport\DonationRepository::class );
        $row  = $repo->find_by_id( $donation_id );
        if ( null === $row ) {
            return;
        }

        $show    = get_post( $show_id );
        $amount  = $row->amount !== null
            ? number_format( $row->amount / 100, 2 ) . ' ' . strtoupper( $row->currency ?? 'usd' )
            : 'amount not provided';
        $platform = $row->platform ?? 'unknown platform';

        if ( $user_id !== null ) {
            $user = get_userdata( $user_id );
            $name = $user ? $user->display_name : "User #{$user_id}";
        } else {
            $name = 'Anonymous';
        }

        $message = sprintf(
            ':heart: Listener support logged — *%s* via *%s*, %s (show: %s)',
            esc_html( $name ),
            esc_html( $platform ),
            esc_html( $amount ),
            $show ? esc_html( $show->post_title ) : "show #{$show_id}"
        );

        wp_remote_post(
            defined( 'MY_SLACK_WEBHOOK_URL' ) ? MY_SLACK_WEBHOOK_URL : '',
            [
                'body'    => wp_json_encode( [ 'text' => $message ] ),
                'headers' => [ 'Content-Type' => 'application/json' ],
                'timeout' => 5,
            ]
        );
    },
    10,
    3
);
