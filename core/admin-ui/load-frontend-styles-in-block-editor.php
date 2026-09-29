<?php
// Load Benecaster's front-end styles into the block editor

// enqueue_block_assets fires for the editor canvas AND the front end, so this
// styles the preview without adding anything to pages that do not use the block.
add_action( 'enqueue_block_assets', function () {
    if ( ! is_admin() ) {
        return; // On the front end the shortcode enqueues its own styles when it renders.
    }
    wp_enqueue_style( 'benecaster-subscribe' );
    wp_enqueue_style( 'benecaster-supporter-wall' ); // pulls in benecaster-badges
} );
