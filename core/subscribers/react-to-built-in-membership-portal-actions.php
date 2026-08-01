<?php
// React to subscriber-initiated lifecycle events from the native billing portal

// Log every subscriber-initiated cancellation request for retention analytics.
add_action( 'benecaster_subscription_cancellation_requested', function ( int $user_id, int $show_id, string $stripe_subscription_id ): void {
    my_addon_retention_log( [
        'event'        => 'cancellation_requested',
        'user_id'      => $user_id,
        'show_id'      => $show_id,
        'requested_at' => current_time( 'mysql', true ),
    ] );
}, 10, 3 );

// Schedule a "win-back" follow-up 24 hours after a cancellation request.
add_action( 'benecaster_subscription_cancellation_requested', function ( int $user_id, int $show_id ): void {
    wp_schedule_single_event( time() + DAY_IN_SECONDS, 'my_addon_send_winback_email', [ $user_id, $show_id ] );
}, 10, 2 );

// Cancel any scheduled win-back flow when a subscriber resumes.
add_action( 'benecaster_subscription_resumed', function ( int $user_id, int $show_id ): void {
    wp_clear_scheduled_hook( 'my_addon_send_winback_email', [ $user_id, $show_id ] );
}, 10, 2 );
