<?php
// Hook into the three buy-up lifecycle actions to drive integrations

// Send a Slack alert when a buy-up grant ends.
add_action( 'benecaster_buyup_revoked', function ( int $user_id, int $buyup_id, int $show_id ): void {
    $user  = get_userdata( $user_id );
    $buyup = $GLOBALS['benecaster_container']->make( \Benecaster\Membership\BuyupRepository::class )->find( $buyup_id );
    if ( ! $user || ! $buyup ) {
        return;
    }
    wp_remote_post( 'https://hooks.slack.com/services/XXX/YYY/ZZZ', [
        'body' => wp_json_encode( [
            'text' => sprintf( '%s lost their %s grant on show %d.', $user->user_login, $buyup['name'], $show_id ),
        ] ),
    ] );
}, 10, 3 );
