<?php
// React to a One-Click Plan Upgrade

// Fires the instant an upgrade is confirmed — before the next cron tick.
add_action( 'benecaster_license_plan_upgraded', function ( string $old_plan, string $new_plan ): void {
    my_addon_log_event( 'plan_upgraded', [
        'from' => $old_plan,
        'to'   => $new_plan,
    ] );
}, 10, 2 );

// Fires from the daily validation cron on ANY plan change — upgrade,
// downgrade, or a server-side correction — not just the one-click flow.
add_action( 'benecaster_license_plan_changed', function ( string $from, string $to ): void {
    if ( '' === $to ) {
        // Licence went invalid or its site token was revoked.
        my_addon_clear_cached_capabilities();
        return;
    }

    my_addon_refresh_cached_capabilities( $to );
}, 10, 2 );
