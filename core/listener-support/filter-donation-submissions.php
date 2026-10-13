<?php
// Refuse Fake Donation Reports Before They Reach Your Integrations

add_filter( 'benecaster_listener_support_accept_donation', function ( bool $accept, array $submission ): bool {
    if ( ! $accept ) {
        return false;
    }
    // A webhook that passed its signature check is trustworthy — keep it.
    if ( $submission['verified'] ) {
        return true;
    }
    // Hand-reported donations: only from platforms this show uses, and with a reference.
    if ( ! in_array( $submission['canonical_platform'], [ 'kofi', 'paypal' ], true ) ) {
        return false;
    }
    return null !== $submission['reference'] && '' !== $submission['reference'];
}, 10, 2 );
