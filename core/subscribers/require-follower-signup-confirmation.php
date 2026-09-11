<?php
// Require email confirmation before a free follower signup mints a token

add_filter( 'benecaster_follower_double_optin', function ( bool $require_confirmation, int $show_id ): bool {
    // Require confirmation only on the show that has been targeted by spam.
    return 123 === $show_id ? true : $require_confirmation;
}, 10, 2 );
