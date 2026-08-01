<?php
// Augment search result excerpts

add_filter(
    'benecaster_search_result_excerpt',
    function ( string $excerpt, int $episode_id, string $q ): string {
        $transcript = get_post_meta( $episode_id, '_my_addon_transcript_snippet', true );
        return $transcript ?: $excerpt;
    },
    10, 3
);
