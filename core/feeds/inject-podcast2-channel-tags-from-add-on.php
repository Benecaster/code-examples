// Inject additional Podcasting 2.0 channel tags from an add-on
add_filter( 'benecaster_feed_podcast_channel_tags', function ( array $tags, int $show_id ): array {
    // Add a podcast index ownership verification string.
    $tags['txt'][] = [
        'purpose' => 'verify',
        'value'   => get_post_meta( $show_id, '_my_addon_podindex_claim', true ) ?: '',
    ];
    // Remove empty claims.
    $tags['txt'] = array_filter( $tags['txt'], fn( $t ) => $t['value'] !== '' );

    return $tags;
}, 10, 2 );

// Override the funding label for shows with a custom campaign label stored in meta.
add_filter( 'benecaster_feed_podcast_funding_label', function ( string $label, int $show_id ): string {
    $custom = (string) get_post_meta( $show_id, '_my_addon_funding_cta', true );
    return $custom !== '' ? $custom : $label;
}, 10, 2 );
