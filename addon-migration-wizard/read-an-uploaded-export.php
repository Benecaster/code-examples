<?php
// See what the migration wizard made of an uploaded export, before anybody is imported

add_filter(
    'benecaster_migration_csv_preview',
    function ( array $payload, \BenecasterMigrationWizard\ParsedCsv $csv ): array {
        // The parse is all there is: the uploaded file is read out of PHP's
        // temporary upload and discarded when the request ends. There is no
        // stored copy to open, deliberately — a subscriber list left under
        // wp-content outlives the wizard session and lands in every backup.
        $payload['has_external_id'] = $csv->has_column( 'Member ID' );

        return $payload;
    },
    10,
    2
);
