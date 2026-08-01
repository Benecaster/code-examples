<?php
// Run post-setup initialisation when the wizard completes

add_action( 'benecaster_setup_wizard_completed', function ( int $show_id, string $bridge_slug ): void {
    if ( $show_id === 0 ) {
        return;
    }

    update_post_meta( $show_id, '_my_addon_setting', 'default_value' );

    if ( 'memberpress' === $bridge_slug ) {
        // MemberPress-specific initialisation.
    }
}, 10, 2 );
