<?php
// Read or override the active bridge for a show from an add-on

$show_id = 42;

// Reading: an empty string means nothing is configured yet.
if ( '' === benecaster_get_active_bridge_slug( $show_id ) ) {
    // Prompt the podcaster, or connect one on their behalf.
    if ( ! benecaster_set_active_bridge( $show_id, 'memberpress' ) ) {
        // Refused: the slug is not registered on this site.
        // Nothing was written — do not report success.
        return new WP_Error(
            'bridge_not_registered',
            __( 'That membership plugin is not available on this site.', 'my-addon' )
        );
    }
}

// Clearing is the empty string, and it always succeeds.
// benecaster_set_active_bridge( $show_id, '' );
