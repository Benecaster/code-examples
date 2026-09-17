// Name an add-on's data for core uninstall

<?php
// wp-content/plugins/benecaster-addon-guests/uninstall.php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Safe if core's uninstall already dropped it.
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}benecaster_guests_appearances" );

// esc_like(): `_` is a LIKE wildcard.
$wpdb->query(
    $wpdb->prepare(
        "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s",
        $wpdb->esc_like( 'benecaster_guests_' ) . '%'
    )
);

wp_clear_scheduled_hook( 'benecaster_guests_daily_sync' );
} );
