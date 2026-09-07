<?php
// React when a podcaster switches your add-on off for one show

add_action( 'benecaster_addon_activation_changed', function ( string $addon_slug, int $show_id, bool $enabled ): void {
    if ( 'benecaster-addon-my-addon' !== $addon_slug ) {
        return;
    }

    if ( $enabled ) {
        // Switched ON. Rebuild whatever was dropped last time.
        my_addon_warm_cache( $show_id );
        return;
    }

    // Switched OFF. Everything below is DERIVED state -- it can be
    // rebuilt from data we still hold, which is the test for whether
    // it is safe to drop here.
    delete_transient( 'my_addon_cache_' . $show_id );
    wp_clear_scheduled_hook( 'my_addon_nightly', [ $show_id ] );

    // NOT here, ever:
    //   - deleting the podcaster's settings for this show
    //   - deleting content they authored through the add-on
    //   - revoking anything they purchased
    // They still own the add-on and are expected to switch it back on.
    // The next `true` cannot undo a delete.
}, 10, 3 );
