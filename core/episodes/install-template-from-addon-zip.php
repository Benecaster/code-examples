<?php
// Programmatically install and activate a design template

add_action( 'benecaster_boot', function (): void {
    // Never override a choice the site owner has already made.
    $active = benecaster_get_active_template();

    // WP_Error means "could not tell" — never install on a failed read.
    if ( is_wp_error( $active ) ) {
        return;
    }

    // A non-built-in template active means the owner picked something.
    // A built-in one means the site is on an untouched default, which is
    // not a choice and is safe to replace.
    if ( null !== $active && ! $active['built_in'] ) {
        return;
    }

    $manifest = benecaster_install_template(
        plugin_dir_path( __FILE__ ) . 'assets/my-template.zip'
    );

    if ( is_wp_error( $manifest ) ) {
        // Every failure arrives this way: unreadable zip, over the 50 MB
        // ceiling, missing or invalid manifest, extraction failure.
        error_log( 'Template install failed: ' . $manifest->get_error_message() );
        return;
    }

    $activated = benecaster_activate_template( $manifest['slug'] );

    if ( is_wp_error( $activated ) ) {
        error_log( 'Template activation failed: ' . $activated->get_error_message() );
    }
} );
