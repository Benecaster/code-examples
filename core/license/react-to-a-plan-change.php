<?php
// React to a Plan Change Without Diffing It Yourself

add_action( 'benecaster_license_plan_changed', function ( string $from, string $to, string $show_uuid ): void {
    // Licence lapsed, was revoked, or was never valid: clear anything
    // you lit up on the way in. $to is '' in all three cases.
    if ( '' === $to ) {
        delete_transient( 'my_addon_upgrade_cta_' . $show_uuid );
        return;
    }

    // '' => 'starter' is the first successful validation on a fresh
    // install, i.e. the licence becoming active.
    if ( '' === $from ) {
        my_addon_on_licence_activated( $to, $show_uuid );
        return;
    }

    my_addon_on_plan_moved( $from, $to, $show_uuid );
}, 10, 3 );
