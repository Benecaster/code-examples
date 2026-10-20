<?php
// Search a secondary data source and inject episode IDs into the Benecaster result set

add_filter(
    'benecaster_search_supplemental_episode_ids',
    function ( array $ids, string $term, int $show_id, array $tiers, array $holdings = [], int $user_id = 0 ): array {
        global $wpdb;

        // A transcript sold as the 'transcripts' buy-up is searchable only by its holders.
        // $holdings is what Benecaster resolved; $tiers is what the SQL filters by, which a filter may have narrowed.
        if ( ! in_array( 'transcripts', $holdings, true ) ) {
            return $ids;
        }

        $table = $wpdb->prefix . 'my_addon_transcripts';
        if ( ! $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) ) {
            return $ids;
        }

        $like = '%' . $wpdb->esc_like( $term ) . '%';

        // Exclude visibility='hidden' to prevent unpublished content leaking via search.
        $rows = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT episode_id
                 FROM {$table}
                 WHERE show_id = %d
                   AND plain_text LIKE %s
                   AND visibility != 'hidden'",
                $show_id,
                $like
            )
        );

        return array_merge( $ids, array_map( 'intval', $rows ) );
    },
    10, 6
);
