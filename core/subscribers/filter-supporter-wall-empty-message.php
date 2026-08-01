<?php
// Override the empty-state copy inside the supporter wall shortcode

add_filter( 'benecaster_supporter_wall_empty_message', function ( string $message, int $show_id, array $atts ): string {
    // Show a different message for a specific show
    if ( 12 === $show_id ) {
        return __( 'Be our first founding supporter!', 'my-theme' );
    }
    return $message;
}, 10, 3 );
