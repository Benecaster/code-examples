<?php
// Automatically enroll Gravity Forms submissions as Benecaster subscribers

// Optional: react to the enrollment server-side (e.g. tag the user in a CRM).
add_action( 'benecaster_subscription_activated', function ( int $user_id, int $show_id, string $tier_slug, string $source ): void {
    if ( 'admin_enrolled' !== $source ) {
        return; // Only react to admin and webhook enrollments, not paid signups.
    }
    my_crm_tag_user( $user_id, 'benecaster-webhook-enrolled' );
}, 10, 4 );
