<?php
// Have Link Health check the links your add-on keeps — a guest's publications

add_filter( 'benecaster_outlinks_health_guest_links', function ( array $links ): array {
    foreach ( my_addon_guests_with_publications() as $guest_id => $publications ) {
        foreach ( $publications as $publication ) {
            if ( empty( $publication['outlinks_id'] ) ) {
                $links[] = [ 'guest_id' => $guest_id, 'url' => $publication['url'] ];
            }
        }
    }
    return $links;
} );
