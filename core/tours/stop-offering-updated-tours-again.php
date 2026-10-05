<?php
// Stop Benecaster offering updated tours again

// Only administrators are offered updated tours again.
add_filter( 'benecaster_tour_reprompt_enabled', function ( bool $enabled, string $tour_id, int $user_id ): bool {
    return user_can( $user_id, 'manage_options' ) ? $enabled : false;
}, 10, 3 );

// Or, to switch it off for everyone and every tour:
// add_filter( 'benecaster_tour_reprompt_enabled', '__return_false' );
