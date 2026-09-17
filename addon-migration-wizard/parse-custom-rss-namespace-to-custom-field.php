<?php
// Parse custom RSS namespace and map to Benecaster custom field

add_filter(
    'benecaster_feed_sync_import_data',
    function ( array $episode_data, SimpleXMLElement $rss_item, int $show_id ): array {
        $ns = $rss_item->getNamespaces( true );

        if ( ! isset( $ns['myshow'] ) ) {
            return $episode_data;
        }

        $myshow    = $rss_item->children( $ns['myshow'] );
        $canonical = trim( (string) ( $myshow->canonical_url ?? '' ) );

        if ( '' !== $canonical ) {
            // Revalidated after this filter; a non-http value stores no link.
            $episode_data['source_link'] = $canonical;
        }

        return $episode_data;
    },
    10,
    3
);
