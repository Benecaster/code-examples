<?php
// Skip importing trailer episodes during feed sync

add_filter(
    'benecaster_feed_sync_should_import',
    function ( bool $should_import, array $item, int $show_id ): bool {
        if ( ! $should_import ) {
            return false;
        }
        $type = strtolower( (string) ( $item['itunes_episode_type'] ?? 'full' ) );
        if ( 'trailer' === $type ) {
            return false;
        }
        return true;
    },
    10,
    3
);
