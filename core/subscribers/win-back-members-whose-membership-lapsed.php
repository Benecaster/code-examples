<?php
// Win back members whose membership lapsed, not the ones who chose to leave

add_action( 'benecaster_subscription_expired', function ( int $user_id, int $show_id, string $tier_slug ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }
    // "Your card stopped working" rather than "sorry to see you go".
    my_esp_add_tag( $user->user_email, 'lapsed-' . $tier_slug );
}, 10, 3 );
