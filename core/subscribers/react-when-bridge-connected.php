<?php
// React when an admin connects a subscription bridge

add_action( 'benecaster_bridge_connected', function ( string $bridge_slug, int $show_id ): void {
    $levels = Benecaster\Plugin::instance()->make( Benecaster\Bridge\BridgeManager::class )
        ->get_active_bridge( $show_id )
        ->get_all_tiers( $show_id );

    foreach ( $levels as $level ) {
        update_post_meta(
            $show_id,
            '_my_addon_level_' . sanitize_key( $level['id'] ) . '_synced',
            current_time( 'mysql' )
        );
    }
}, 10, 2 );
