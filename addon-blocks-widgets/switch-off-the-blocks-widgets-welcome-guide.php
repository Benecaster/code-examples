<?php
// Switch off the Blocks & Widgets welcome guide

// A client site: never show the welcome guide to anyone.
add_action( 'enqueue_block_editor_assets', function (): void {
    wp_add_inline_script(
        'benecaster-blocks-widgets-editor',
        "wp.data.dispatch( 'core/preferences' ).set( 'benecaster/blocks-widgets', 'welcomeGuideSeen', true );",
        'before'
    );
} );
