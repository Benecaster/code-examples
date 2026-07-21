// Parse custom RSS namespace and map to Benecaster custom field
add_filter(
    'benecaster_feed_sync_import_data',
    function ( array $episode_data, array $item, int $show_id ): array {
        $raw = $item['raw_xml'] ?? null;
        if ( ! $raw instanceof SimpleXMLElement ) {
            return $episode_data;
        }
        $ns = $raw->getNamespaces( true );
        if ( ! isset( $ns['myshow'] ) ) {
            return $episode_data;
        }
        $myshow    = $raw->children( $ns['myshow'] );
        $transcript = trim( (string) ( $myshow->transcript_url ?? '' ) );
        if ( '' !== $transcript ) {
            $episode_data['custom_fields']['transcript_url'] = esc_url_raw( $transcript );
        }
        return $episode_data;
    },
    10,
    3
);
