<?php
// Sync a verified email change to your CRM

add_action(
    'benecaster_email_changed',
    function ( int $user_id, string $old_email, string $new_email ): void {
        // Cheap: the hook fires inside the verification request, which is a
        // browser redirect the subscriber is waiting on.
        wp_schedule_single_event(
            time() + 10,
            'my_addon_sync_contact',
            [ $user_id, $old_email, $new_email ]
        );
    },
    10,
    3
);
