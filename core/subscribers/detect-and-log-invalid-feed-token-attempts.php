<?php
// Detect and log invalid feed token attempts

add_action( 'benecaster_token_invalid', function ( string $token_prefix, int $show_id ) {
    // Log to your security/observability platform. Never log the raw
    // requester IP — if you need a per-source breakdown, use
    // benecaster_invalid_token_recorded instead, whose $context
    // carries an already-salted ip_hash.
    error_log( sprintf( 'Invalid Benecaster token attempt: prefix=%s show=%d',
        $token_prefix,
        $show_id
    ) );
}, 10, 2 );
