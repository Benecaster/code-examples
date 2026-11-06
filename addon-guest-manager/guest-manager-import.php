<?php
// Run or watch the guest import from code

// Tell a Slack channel how many guests an import made.
add_action( 'benecaster_guest_manager_after_import', static function ( array $result ): void {
    if ( $result['created'] + $result['linked_existing'] === 0 ) {
        return;
    }
    my_slack_post( sprintf(
        'Guest import: %d new guests, %d existing guests linked, %d episode links.',
        $result['created'],
        $result['linked_existing'],
        $result['links_added']
    ) );
} );
