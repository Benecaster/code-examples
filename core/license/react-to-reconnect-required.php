<?php
// Detect and respond to per-show token revocation so add-ons can pause outbound work before the operator reconnects

add_action( 'benecaster_license_unauthorized_strike', function ( int $strike_count, string $show_uuid ): void {
    // First strike is usually a transient header-stripping incident — log it
    // so operators can correlate against host proxy anomalies, but do not
    // change behavior yet. Strike 2 fires the reconnect_required action.
    my_addon_metric( 'benecaster.license.401_strike', [
        'count'     => $strike_count,
        'show_uuid' => $show_uuid,
    ] );
}, 10, 2 );

add_action( 'benecaster_license_reconnect_required', function ( string $show_uuid ): void {
    // Pause outbound work for this specific show — other shows are unaffected.
    // The Reconnect to Benecaster admin notice already prompts the operator.
    my_addon_pause_outbound_syncs_for_show( $show_uuid );
} );
