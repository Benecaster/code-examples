<?php
// Exclude an episode from all search results

add_filter(
    'benecaster_search_indexable',
    function ( bool $indexable, int $episode_id, string $q ): bool {
        return ! (bool) get_post_meta( $episode_id, '_my_addon_hide_from_search', true );
    },
    10, 3
);
