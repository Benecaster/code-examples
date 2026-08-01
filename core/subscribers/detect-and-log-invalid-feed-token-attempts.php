<?php
// Detect and log invalid feed token attempts

add_action( 'benecaster_token_invalid', function ( string $token_prefix, int $show_id ) {
    // Log to your security/observability platform.
    error_log( sprintf( 'Invalid Benecaster token attempt: prefix=%s show=%d ip=%s',
        $token_prefix,
        $show_id,
        $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ) );
    // Or push to a rate-limiter keyed on IP + show.
}, 10, 2 );
