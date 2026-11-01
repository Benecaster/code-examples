<?php
// Change an exported Email Editor file, or react to an import

add_filter( 'benecaster_email_editor_export_file', function ( array $file, int $target ): array {
    // A key the importer does not name is ignored, so a note here is safe to add.
    $file['exported_from'] = home_url();

    return $file;
}, 10, 2 );

add_action( 'benecaster_email_editor_after_import', function ( array $result, int $target ): void {
    if ( [] !== $result['failed'] ) {
        error_log( 'Designs not imported: ' . implode( ', ', $result['failed'] ) );
    }
}, 10, 2 );
