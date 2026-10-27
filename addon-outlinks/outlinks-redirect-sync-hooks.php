<?php
// Run your own code when a tracked link follows its Reference Library item — a URL edit or a deleted item

add_action( 'benecaster_outlinks_redirect_destination_sync_after', function ( array $redirect, string $destination ): void {
    error_log( sprintf( '/go/%s now sends visitors to %s (was %s)', $redirect['slug'], $destination, $redirect['destination_url'] ) );
}, 10, 2 );
