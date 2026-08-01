<?php
// Trigger push notifications when scheduled episodes unlock

add_action( 'benecaster_availability_check_run', function ( int $unlocked_count, array $rows ) {
    if ( $unlocked_count === 0 ) {
        return;
    }
    foreach ( $rows as $row ) {
        // $row has episode_id, show_id, tier_slug, available_datetime.
        my_push_service_notify_tier( (int) $row->show_id, (string) $row->tier_slug,
            'A new episode just unlocked for your tier!' );
    }
}, 10, 2 );
