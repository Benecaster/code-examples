<?php
// Toggle an add-on's verbose logging or extra diagnostics in lock-step with Benecaster Support Mode

add_action(
    'benecaster_support_mode_enabled',
    function ( int $auto_disable_at ): void {
        update_option( 'my_addon_verbose_logging', true, false );
        // Optional: schedule a parallel cleanup so the add-on never logs past
        // the same cutoff Benecaster uses, even if its cron is rescheduled.
        wp_clear_scheduled_hook( 'my_addon_support_mode_cleanup' );
        wp_schedule_single_event( $auto_disable_at, 'my_addon_support_mode_cleanup' );
    }
);

add_action(
    'benecaster_support_mode_disabled',
    function ( string $reason ): void {
        // $reason is 'manual' when the admin toggled off, 'auto' when the
        // 7-day cron fired. Tear down regardless.
        update_option( 'my_addon_verbose_logging', false, false );
        wp_clear_scheduled_hook( 'my_addon_support_mode_cleanup' );
    }
);
