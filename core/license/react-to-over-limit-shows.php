<?php
// Know which shows are disabled by the plan's show limit

// Hide over-limit shows from an add-on's own directory listing.
add_filter( 'my_addon_listed_show_ids', function ( array $ids ): array {
    return array_values( array_diff( $ids, benecaster_get_over_limit_show_ids() ) );
} );

// React to a change, then re-read the authoritative set rather than
// trusting the delta you were handed.
add_action( 'benecaster_show_limit_exceeded', function (): void {
    $disabled = benecaster_get_over_limit_show_ids();

    if ( [] === $disabled ) {
        return; // Within limit, or an unlimited plan.
    }

    my_addon_pause_scheduled_jobs_for( $disabled );
} );
