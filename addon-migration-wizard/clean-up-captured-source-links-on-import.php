<?php
// Clean up captured source links on import

add_action(
    'benecaster_episode_imported',
    function ( int $episode_id, int $show_id, SimpleXMLElement $rss_item ): void {
        $meta = new \Benecaster\Episode\EpisodeMeta( $episode_id );
        $link = $meta->get_source_link();

        if ( '' === $link ) {
            return; // No usable <link> on the item.
        }

        $parts = wp_parse_url( $link );
        parse_str( $parts['query'] ?? '', $query );

        foreach ( [ 'utm_source', 'utm_medium', 'utm_campaign', 'ref' ] as $drop ) {
            unset( $query[ $drop ] );
        }

        // set_source_link() revalidates and, on a bad value, removes the key
        // rather than storing ''.
        $meta->set_source_link(
            $parts['scheme'] . '://' . $parts['host'] . ( $parts['path'] ?? '' )
                . ( [] === $query ? '' : '?' . http_build_query( $query ) )
        );
    },
    10,
    3
);
