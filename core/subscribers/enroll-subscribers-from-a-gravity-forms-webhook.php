<?php
// Automatically enroll Gravity Forms submissions as Benecaster subscribers

// Gravity Forms webhook Request Body (Select Fields):
// {
//     "addresses": ["{Email:1}"],
//     "tier_slug": "supporter"
// }

// Optional: react to the enrollment server-side (e.g. tag the user in a CRM).
add_action( 'benecaster_subscription_activated', function ( int $user_id, int $show_id, string $tier_slug, string $source ): void {
    if ( 'admin_enrolled' !== $source ) {
        return; // Only react to bulk/webhook enrollments, not paid signups.
    }
    my_crm_tag_user( $user_id, 'benecaster-webhook-enrolled' );
}, 10, 4 );
