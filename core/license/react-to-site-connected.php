<?php
// Fire add-on side effects the moment an OAuth site-linking exchange succeeds for a specific show

add_action( 'benecaster_site_connected', function ( array $data ): void {
    $show_uuid = (string) ( $data['show_uuid'] ?? '' );

    // Kick off a first-time sync as soon as this show is licensed.
    wp_schedule_single_event( time() + 10, 'my_addon_initial_sync', [ $show_uuid ] );

    // Log the connect event without persisting the token itself.
    my_addon_audit_log( sprintf(
        'Benecaster connected: show_uuid=%s license_id=%d plan=%s',
        $show_uuid,
        (int) ( $data['license_id'] ?? 0 ),
        (string) ( $data['plan'] ?? '' )
    ) );
} );
