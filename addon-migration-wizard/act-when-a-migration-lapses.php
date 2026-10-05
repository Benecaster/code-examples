<?php
// Act when somebody's migration lapses — and not on every revoked feed on the site

add_action(
    'benecaster_migration_subscriber_dropped',
    function ( int $user_id, int $show_id ): void {
        // Their private access has already ended and their record reads "lapsed".
        my_crm_tag( $user_id, 'migration-lapsed' );
    },
    10,
    2
);
