<?php
/**
 * Stop a third-party payment gateway charging real customers from a staging clone
 */

use Benecaster\Payment\NonProductionChargeBlocked;
use Benecaster\Payment\OutboundChargeGuard;

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    $guard = $container->make( OutboundChargeGuard::class );

    // Inside your gateway, before any charge or lifecycle call.
    try {
        $guard->assert_may_move_money( 'myaddon_create_subscription' );

        $subscription = my_gateway_api()->createSubscription( $customer, $plan );
    } catch ( NonProductionChargeBlocked $e ) {
        // Refuse the way THIS entry point already refuses. A REST route
        // returns WP_Error; a webhook returns 200 without acting, so the
        // provider does not retry; cron logs and skips.
        return new WP_Error(
            'myaddon_billing_unavailable',
            __( 'Billing is unavailable on this site.', 'my-addon' ),
            [ 'status' => 409 ]
        );
    }
} );
