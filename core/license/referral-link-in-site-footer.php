<?php
// Put a "Powered by Benecaster" referral link in your theme's footer

// In a child theme's functions.php:
add_action( 'wp_footer', static function (): void {
    $link = do_shortcode( '[benecaster_referral_link label="Podcast memberships powered by Benecaster"]' );
    if ( '' === $link ) {
        return; // No cached referral link, or the licence is not active.
    }
    printf( '<p class="site-credit">%s</p>', $link ); // Already escaped by the shortcode.
} );

// Or restyle it everywhere it appears:
add_filter( 'benecaster_referral_link_output', static function ( string $html, string $link, array $atts ): string {
    return 'url' === $atts['style'] ? $html : '<span class="my-credit">' . $html . '</span>';
}, 10, 3 );
