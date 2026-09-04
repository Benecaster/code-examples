<?php
// Capture custom RSS namespace data during an import

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
            update_post_meta( $episode_id, '_my_addon_sponsor', $sponsor );
        }
    },
    10,
    3
);
