<?php
// Remove your add-on's rows when a show is deleted

// Benecaster removes the show's content after this action, so at the default
// priority everything the show owned is still readable here.
add_action( 'benecaster_show_deleted', function ( int $show_id ): void {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix . 'my_addon_show_settings', [ 'show_id' => $show_id ], [ '%d' ] );
    delete_option( "my_addon_show_{$show_id}" );
} );

// Rows keyed to a reference library item: this fires once per item when
// the show is deleted, as well as when one item is deleted on its own.
add_action( 'benecaster_reference_library_item_deleted', function ( int $item_id, int $show_id ): void {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix . 'my_addon_redirects', [ 'reference_id' => $item_id ], [ '%d' ] );
}, 10, 2 );
