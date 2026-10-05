<?php
// Sync your migration outreach notes to your CRM

// Mirror each note into a CRM as it is saved.
add_action( 'benecaster_migration_patron_note_saved', function ( int $patron_id, int $import_id, int $show_id, string $notes ): void {
    // The note is the podcaster's, not the subscriber's — send it somewhere
    // only your team can read. $notes is empty when the note was cleared.
    my_crm_update_note( $patron_id, $notes );
}, 10, 4 );
