<?php
// Walk the whole guest roster from another add-on

// Backfill a search index with every guest, 100 at a time.
if ( function_exists( 'benecaster_guest_manager_get_guests' ) ) {
    $page = 1;
    do {
        $result = benecaster_guest_manager_get_guests( [ 'page' => $page, 'per_page' => 100 ] );
        foreach ( $result['guests'] as $guest ) {
            my_addon_index_guest( $guest['id'], $guest['name'] . ' ' . $guest['organization'] . ' ' . $guest['bio'] );
        }
        $page++;
    } while ( ( $page - 1 ) * 100 < $result['total'] );
}
