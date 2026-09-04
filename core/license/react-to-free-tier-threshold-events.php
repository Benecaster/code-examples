<?php
// React to the free-tier threshold warning

// Show a dashboard notice when the site approaches its Launch-tier limit.
add_action( 'benecaster_license_free_threshold_warning', function( int $count ): void {
    // $count is the current paying subscriber count.
    // Display a persistent admin notice encouraging the podcaster to review plan options.
    update_option( 'my_plugin_threshold_notice', $count );
} );

// Clear the CTA once the plan is no longer the free tier. This fires only on a
// real transition, so there is no previous value to store and diff.
add_action( 'benecaster_license_plan_changed', function ( string $from, string $to ): void {
    if ( 'free' !== $to ) {
        delete_option( 'my_plugin_threshold_notice' );
    }
}, 10, 2 );

// $to is '' when the licence lapses or its token is revoked, so the branch above
// deliberately leaves the notice in place in that case - a site that has fallen
// out of validation has not upgraded.
