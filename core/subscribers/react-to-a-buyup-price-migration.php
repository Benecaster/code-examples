<?php
// React to a buy-up price migration

add_action(
    'benecaster_buyup_subscriber_migrated',
    function ( int $user_id, int $show_id, int $buyup_id, float $old_price, float $new_price ): void {
        // Log every price migration to an external system, e.g. a CRM.
        my_crm_log_price_change( $user_id, $buyup_id, $old_price, $new_price );
    },
    10,
    5
);

add_action(
    'benecaster_buyup_price_migration_complete',
    function ( int $buyup_id, int $migrated, array $skipped_billing, array $failures ): void {
        // Send your own operator alert if anything needed a second look —
        // Benecaster's own admin notice already covers this for the
        // podcaster, this is for a separate ops channel (e.g. Slack).
        if ( [] !== $failures ) {
            my_ops_alert( sprintf( '%d buy-up migrations failed for buy-up #%d', count( $failures ), $buyup_id ) );
        }
    },
    10,
    4
);
