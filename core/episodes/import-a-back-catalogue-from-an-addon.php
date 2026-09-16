<?php
// Import a back catalogue from an add-on

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $importer = $container->make( \Benecaster\Feed\FeedBulkImporter::class );

    // Your own admin action. Validate before starting: start_import() does not.
    add_action( 'admin_post_my_addon_import', function () use ( $importer ): void {
        check_admin_referer( 'my_addon_import' );
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Not allowed.' );
        }

        $show_id  = absint( $_POST['show_id'] ?? 0 );
        $feed_url = esc_url_raw( wp_unslash( $_POST['feed_url'] ?? '' ) );
        if ( 'benecaster_show' !== get_post_type( $show_id ) || ! filter_var( $feed_url, FILTER_VALIDATE_URL ) ) {
            wp_die( 'Choose a show and a feed URL.' );
        }

        // One job per show at a time: there is no lock.
        $active = $importer->get_active_job_id( $show_id );
        if ( '' !== $active && 'running' === ( $importer->get_progress( $active )['status'] ?? '' ) ) {
            wp_die( 'An import is already running for this show.' );
        }

        $importer->start_import( $show_id, $feed_url );
        wp_safe_redirect( admin_url( 'admin.php?page=my-addon&import=started' ) );
        exit;
    } );
} );

// The reconciliation report: fires for failures too.
add_action( 'benecaster_bulk_import_completed', function ( int $show_id, array $progress ): void {
    update_option( "my_addon_import_report_{$show_id}", [
        'status'   => $progress['status'],
        'imported' => $progress['imported'],
        'skipped'  => $progress['skipped'],
        'errors'   => $progress['errors'],
        'error'    => $progress['error_msg'] ?? '',
    ], false );
}, 10, 2 );
