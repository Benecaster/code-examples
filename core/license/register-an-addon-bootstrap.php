<?php
// Register an Add-on Bootstrap With Core's Entitlement Gate

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    benecaster_register_addon(
        'benecaster-addon-guest-manager',
        function ( \Benecaster\Container $container ) {
            // This only runs when 'benecaster-addon-guest-manager' is
            // entitled on at least one connected show — no
            // any_show_addon_is_active() check needed here.
            $container->make( \GuestManager\GuestManagerPlugin::class )->register();
        },
        [
            'version'      => '1.60.0',                        // minimum Benecaster core version
            'capabilities' => [ 'benecaster_addon_is_active' ], // function/class names that must exist
        ]
    );
} );
