<?php
// Read or override the active bridge for a show from an add-on

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    $bridge_manager = $container->make( \Benecaster\Bridge\BridgeManager::class );

    $bridge = $bridge_manager->get_active_bridge( 42 );
    if ( $bridge instanceof \Benecaster\Bridge\NullBridge ) {
        // No bridge configured — prompt the user or fall back.
    }

    // Programmatically activate MemberPress for show 42.
    $bridge_manager->set_active_bridge( 42, 'memberpress' );
} );
