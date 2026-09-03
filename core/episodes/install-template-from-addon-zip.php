<?php
// Programmatically install and activate a design template

add_action( 'benecaster_boot', function ( \Benecaster\Container $c ): void {
    $uploader = $c->make( \Benecaster\Template\TemplateUpload::class );

    // Never override a choice the site owner has already made.
    if ( null !== $uploader->get_active() ) {
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

    $uploader->activate( $manifest['slug'] );
} );
