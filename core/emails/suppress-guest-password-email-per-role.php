<?php
// Suppress the Set-Password Email for a Role or a Provisioning Flow

add_filter(
    'benecaster_subscribe_send_password_email',
    function ( bool $should_send, int $user_id, int $show_id, string $source ): bool {
        // Suppress for members of "founding_supporter" — that role's
        // onboarding is handled by our concierge plugin, and a duplicate
        // reset link would confuse subscribers.
        $user = get_userdata( $user_id );
        if ( $user && in_array( 'founding_supporter', (array) $user->roles, true ) ) {
            return false;
        }

        // Or suppress per flow. A bulk import of 400 addresses sends 400
        // reset emails on top of 400 welcome emails; a site that onboards
        // those people by hand may not want the second wave at all.
        if ( 'bulk_enroll' === $source ) {
            return false;
        }

        return $should_send;
    },
    10,
    4
);
