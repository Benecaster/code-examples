<?php
// Act when a migrated subscriber signs up — and not for every other new subscriber

add_action(
    'benecaster_migration_subscriber_completed',
    function ( int $user_id, int $show_id, string $tier_slug ): void {
        // Their migration record already reads "signed up", so reading it here is safe.
        my_crm_tag( $user_id, 'migration-completed', $tier_slug );
    },
    10,
    3
);
