<?php
// React to the free-tier threshold warning

// Show a dashboard notice when the site approaches its Launch-tier limit.
add_action( 'benecaster_license_free_threshold_warning', function( int $count ): void {
    // $count is the current paying subscriber count.
    // Display a persistent admin notice encouraging the podcaster to review plan options.
    update_option( 'my_plugin_threshold_notice', $count );
} );

// Clear the CTA once the plan is no longer the free tier.
add_action( 'benecaster_license_validated', function( array $response ): void {
    if ( 'free' !== ( $response['plan'] ?? '' ) ) {
        delete_option( 'my_plugin_threshold_notice' );
    }
} );
