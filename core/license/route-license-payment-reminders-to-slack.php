<?php
// Route License Payment Reminders to Slack

// Day-0: the grace window just opened (first payment-failed response).
add_action( 'benecaster_license_grace_started', function ( int $started_at, string $reason ): void {
    if ( 'payment_failed' !== $reason ) {
        return;
    }

    wp_remote_post( MY_SLACK_WEBHOOK_URL, [
        'body' => wp_json_encode( [
            'text' => sprintf(
                ':rotating_light: *Benecaster payment failed* — grace window open. 30 days to update billing at benecaster.com. Site: %s',
                home_url()
            ),
        ] ),
    ] );
}, 10, 2 );

// Day 10, 20, 29: reminders dispatched by PaymentGraceReminderCron.
add_action( 'benecaster_license_payment_grace_reminder_sent', function ( int $day_bucket, int $started_at ): void {
    $days_remaining = 30 - $day_bucket;

    wp_remote_post( MY_SLACK_WEBHOOK_URL, [
        'body' => wp_json_encode( [
            'text' => sprintf(
                ':warning: *Benecaster billing reminder* — Day %d. %d %s remaining in the grace window. Update billing at benecaster.com. Site: %s',
                $day_bucket,
                $days_remaining,
                1 === $days_remaining ? 'day' : 'days',
                home_url()
            ),
        ] ),
    ] );
}, 10, 2 );
