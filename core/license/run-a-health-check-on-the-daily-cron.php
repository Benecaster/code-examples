<?php
// Run a health check on the daily license cron in addition to the hourly admin sweep

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $notices = $container->make( NoticeManager::class );
    $check   = new StripeWebhookHealthCheck( $notices );

    // Admin sweep (transient-gated, at most once an hour).
    $notices->add_health_check( $check );

    // Daily cron sweep — also runs the check on a fixed cadence so the
    // notice shows up even if no admin ever opens wp-admin between firings.
    add_action(
        'benecaster_license_cron_complete',
        function () use ( $notices, $check ): void {
            $notices->run_health_check( $check );
        }
    );
} );
