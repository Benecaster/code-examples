<?php
// Tag a lost listener by why they left — and a follower as a follower

use Benecaster\Token\RevocationReasons;

add_action( 'benecaster_token_revoked', function ( int $token_id, int $user_id, int $show_id, string $reason ): void {
    $user = get_userdata( $user_id );
    $type = benecaster_get_token_type( $token_id ); // the row survives revocation
    if ( ! $user || null === $type ) {
        return;
    }

    $who = 'follower' === $type['base'] ? 'follower' : 'subscriber';

    $why = match ( $reason ) {
        RevocationReasons::BRIDGE_CANCELLATION  => 'cancelled',
        RevocationReasons::ADMIN_REVOKED        => 'removed',
        RevocationReasons::MANUAL_GRANT_EXPIRED => 'grant-ended',
        default                                 => 'ended',
    };

    my_esp_add_tag( $user->user_email, "{$who}-{$why}" );
}, 10, 4 );
