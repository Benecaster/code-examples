<?php
// Wrap or annotate what a Benecaster block renders

// Give every Episode Player block a wrapper your theme can style.
add_filter( 'benecaster_blocks_block_render', function ( string $html, string $block_name, array $attributes, string $shortcode ): string {
    if ( 'benecaster/episode-player' !== $block_name || '' === $html ) {
        return $html;
    }
    return '<div class="my-theme-player">' . $html . '</div>';
}, 10, 4 );
