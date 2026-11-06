<?php
// Search a podcaster's catalogue from the admin, as the AI Search production panel does

// Keep a short history of the podcaster's own lookups, for the team's prep notes.
add_action( 'benecaster_ai_search_after_panel_search', function ( string $query, array $show_ids, array $results ): void {
    $log   = (array) get_option( 'my_prep_lookups', [] );
    $log[] = [ 'q' => $query, 'shows' => $show_ids, 'found' => array_column( $results, 'id' ), 'at' => gmdate( 'Y-m-d H:i:s' ) ];
    update_option( 'my_prep_lookups', array_slice( $log, -50 ), false );
}, 10, 3 );
