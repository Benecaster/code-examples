<?php
// Use your own icon set for social, platform and share links

add_filter( 'benecaster_platform_icon_svg', function ( string $svg, string $slug, string $context ): string {
    // Map Benecaster's slugs to the theme's sprite ids; keep Benecaster's icon for the rest.
    $map = [ 'twitter_x' => 'x', 'apple_podcasts' => 'apple-podcasts', 'rss' => 'feed' ];
    $id  = $map[ $slug ] ?? null;
    if ( null === $id ) {
        return $svg;
    }
    return sprintf(
        '<svg width="1em" height="1em" aria-hidden="true" focusable="false"><use href="%s"></use></svg>',
        esc_url( get_theme_file_uri( 'icons.svg' ) . '#' . $id )
    );
}, 10, 3 );
