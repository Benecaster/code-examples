<?php
// Restrict a donor wall to Stripe-only donations on a specific show.
add_filter( 'benecaster_donor_wall_query_args', function ( array $args, int $show_id ): array {
    // 42 = the show whose wall should be Stripe-only. All other shows keep
    // the default all-platforms behaviour.
    if ( 42 !== $show_id ) {
        return $args;
    }
    $args['platform'] = 'stripe';
    return $args;
}, 10, 2 );
