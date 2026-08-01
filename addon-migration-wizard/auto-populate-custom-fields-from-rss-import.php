<?php
// Auto-populate custom fields from imported RSS data

add_action(
    'benecaster_episode_imported',
    function ( int $episode_id, int $show_id, array $source_item ): void {
        // $source_item['raw_xml'] holds the untouched <item> as a SimpleXMLElement.
        $item = $source_item['raw_xml'] ?? null;
        if ( ! $item instanceof SimpleXMLElement ) {
            return;
        }
        $ns = $item->getNamespaces( true );
        if ( ! isset( $ns['mystudio'] ) ) {
            return;
        }
        $mystudio = $item->children( $ns['mystudio'] );
        $sponsor  = trim( (string) ( $mystudio->sponsor ?? '' ) );
        if ( '' !== $sponsor ) {
            benecaster_update_field( 'sponsor', $sponsor, $episode_id );
        }
    },
    10,
    3
);
