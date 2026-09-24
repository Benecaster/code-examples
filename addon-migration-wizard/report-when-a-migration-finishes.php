<?php
// Report when a migration finishes

add_action(
    'benecaster_migration_import_complete',
    static function ( int $show_id, string $platform, int $imported, int $skipped, int $batch_id ): void {
        // "skipped" is not "failed" — report both, and do not colour the
        // second one red. A top-up import skips almost everybody by design.
        error_log( sprintf(
            'Migration %d finished: %d imported, %d skipped (see the batch reconciliation for reasons).',
            $batch_id,
            $imported,
            $skipped
        ) );
    },
    10,
    5
);
