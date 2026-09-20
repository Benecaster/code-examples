<?php
// Capture custom RSS namespace data during an import

// The ID of your "Sponsor" field — shown (click to copy) in the ID column
// of Benecaster → Fields → edit the field group. benecaster_update_field()
// addresses fields by ID, like benecaster_get_field().
const MY_ADDON_SPONSOR_FIELD_ID = 12;

add_action(
    'benecaster_episode_imported',
    function ( int $episode_id, int $show_id, SimpleXMLElement $rss_item ): void {
        $ns = $rss_item->getNamespaces( true );

        if ( ! isset( $ns['mystudio'] ) ) {
            return;
        }

        $mystudio = $rss_item->children( $ns['mystudio'] );
        $sponsor  = trim( (string) ( $mystudio->sponsor ?? '' ) );

        if ( '' !== $sponsor ) {
            benecaster_update_field( MY_ADDON_SPONSOR_FIELD_ID, $episode_id, $sponsor );
        }
    },
    10,
    3
);
