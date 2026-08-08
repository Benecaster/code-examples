<?php
// Track the payment-failed license grace lifecycle

add_action( 'benecaster_license_grace_started', function ( int $started_at, string $reason ): void {
    // Payment just failed. Enqueue a "billing update needed" email to the
    // site operator, or push an event to your monitoring pipeline.
    wp_mail( get_option( 'admin_email' ), 'Benecaster: payment failed', sprintf(
        'Your Benecaster subscription just failed a payment (%s). You have 30 days to update billing at benecaster.com before subscribers drop to the public feed.',
        $reason
    ) );
}, 10, 2 );

add_action( 'benecaster_license_grace_expired', function ( int $started_at ): void {
    // 30 days elapsed — subscribers are now on the public feed. Fires
    // once per cron cycle; guard with a wp_option if you only want the
    // FIRST expiry to trigger an alert.
    if ( ! get_option( 'my_addon_grace_expiry_alerted' ) ) {
        update_option( 'my_addon_grace_expiry_alerted', 1 );
        // ... send the "subscribers now on public feed" alert ...
    }
} );

add_action( 'benecaster_license_grace_recovered', function ( int $started_at, int $duration_seconds ): void {
    // Payment recovered. Clear any expiry-side state and, if grace ran
    // long enough that expired fired, notify recovery.
    delete_option( 'my_addon_grace_expiry_alerted' );
    if ( $duration_seconds >= 30 * DAY_IN_SECONDS ) {
        // ... send "your subscribers have their private feeds back" alert ...
    }
}, 10, 2 );
