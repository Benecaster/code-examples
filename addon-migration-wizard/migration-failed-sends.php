<?php
// Reshape, or act on, the list of migration emails that did not send

// Keep the panel to the welcome only — the other four are informational.
add_filter(
    'benecaster_migration_failed_sends',
    function ( array $payload, int $import_id, int $show_id ): array {
        $payload['items'] = array_values( array_filter(
            $payload['items'],
            static fn ( array $row ): bool => 'migration_welcome' === $row['emailType']
        ) );
        // Keep the counts true to what is left, or the panel says
        // "Showing 3 of 10" about rows that will never appear.
        $payload['total']     = (int) ( $payload['byType']['migration_welcome'] ?? 0 );
        $payload['shown']     = count( $payload['items'] );
        $payload['truncated'] = $payload['shown'] < $payload['total'];

        return $payload;
    },
    10,
    3
);

// Tell your own helpdesk when a podcaster retries one.
add_action(
    'benecaster_migration_failed_send_retried',
    function ( int $queue_id, int $import_id, int $show_id ): void {
        my_support_log( "migration {$import_id}: queue row {$queue_id} retried" );
    },
    10,
    3
);
