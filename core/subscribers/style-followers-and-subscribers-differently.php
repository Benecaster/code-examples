<?php
// Style followers and subscribers differently

add_filter( 'benecaster_user_badges', function ( array $badges ): array {
    return array_values( array_filter(
        $badges,
        static fn( $b ) => 'follower_auto' !== ( $b->source ?? '' )
    ) );
}, 20 ); // after core appends it at priority 15
