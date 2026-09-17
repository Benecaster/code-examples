<?php
// Skip importing trailer episodes during feed sync

add_filter(
    'benecaster_feed_sync_should_import',
    function ( bool $should_import, SimpleXMLElement $rss_item, int $show_id ): bool {
        if ( ! $should_import ) {
            return false;
        }

        $itunes = $rss_item->children( 'http://www.itunes.com/dtds/podcast-1.0.dtd' );
        $type   = strtolower( trim( (string) ( $itunes->episodeType ?? '' ) ) );

        return 'trailer' !== $type;
    },
    10,
    3
);
