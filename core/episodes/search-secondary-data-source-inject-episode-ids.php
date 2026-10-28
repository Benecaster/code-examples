<?php
// Search a secondary data source and inject episode IDs into the Benecaster result set

add_filter(
    'benecaster_search_supplemental_episode_ids',
    function ( array $ids, string $term, int $show_id, array $tiers, array $holdings = [], int $user_id = 0 ): array {
        global $wpdb;

        // Your add-on's own table, which is yours to change and safe to rely on.
        $table = $wpdb->prefix . 'my_addon_guest_notes';
        if ( ! $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) ) {
            return $ids;
        }

        // Members-only notes are searchable only by holders of your buy-up. 'guest-notes' stands in
        // for the slug benecaster_get_buyup_slug() gives your buy-up on this show.
        // $holdings is what Benecaster resolved; $tiers is what the SQL filters by, which a filter may have narrowed.
        $public_only = in_array( 'guest-notes', $holdings, true ) ? '' : 'AND is_public = 1';

        $like = '%' . $wpdb->esc_like( $term ) . '%';
        $rows = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT DISTINCT episode_id
                 FROM {$table}
                 WHERE show_id = %d
                   AND notes LIKE %s
                   {$public_only}",
                $show_id,
                $like
            )
        );

        return array_merge( $ids, array_map( 'intval', $rows ) );
    },
    10, 6
);
