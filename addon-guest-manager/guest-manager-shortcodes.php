<?php
// Place guests anywhere with Guest Manager's shortcodes

// A guest card in a theme template, only where Guest Manager can draw one.
if ( shortcode_exists( 'benecaster_guest' ) ) {
    echo do_shortcode( '[benecaster_guest guest="ada-lovelace" bio="none"]' );
}

// Never show a full bio in a card on the front page, whatever the shortcode says.
add_filter( 'shortcode_atts_benecaster_guest', static function ( array $atts ): array {
    if ( is_front_page() && 'full' === $atts['bio'] ) {
        $atts['bio'] = 'excerpt';
    }
    return $atts;
} );
