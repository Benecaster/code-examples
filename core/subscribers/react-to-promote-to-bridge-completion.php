<?php
// Run custom logic after the Promote-to-Bridge wizard finishes

add_action( 'benecaster_bridge_promote_complete', function ( int $show_id, string $target_slug, int $promoted, int $skipped, int $errors ): void {
    if ( $errors > 0 ) {
        error_log( sprintf(
            'Promote to %s on show %d had %d failed rows out of %d.',
            $target_slug, $show_id, $errors, $promoted + $errors
        ) );
    }
}, 10, 5 );

add_action( 'benecaster_promote_grace_expired', function ( int $user_id, int $show_id, string $tier_slug ): void {
    // Subscriber failed to re-authorize within the grace window — log to your CRM, etc.
}, 10, 3 );
