<?php
// Suppress the Guest Password-Set Email for a Specific Role

add_filter(
    'benecaster_subscribe_send_password_email',
    function ( bool $should_send, int $user_id, int $show_id ): bool {
        // Suppress the Benecaster email for members of "founding_supporter" —
        // that role's onboarding is handled by our concierge plugin and a
        // duplicate reset link would confuse subscribers.
        $user = get_userdata( $user_id );
        if ( $user && in_array( 'founding_supporter', (array) $user->roles, true ) ) {
            return false;
        }
        return $should_send;
    },
    10,
    3
);
