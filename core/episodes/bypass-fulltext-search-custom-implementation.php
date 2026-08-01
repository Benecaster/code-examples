<?php
// Bypass the standard FULLTEXT search with a custom implementation

add_filter(
    'benecaster_search_pre_results',
    function ( ?array $pre, string $q, int $show_id, array $tiers, int $page, int $per_page ): ?array {
        // Return null to let core handle it.
        if ( ! my_addon_is_active() ) {
            return null;
        }
        $hits = my_search_engine()->query( $q, $show_id, $tiers, $page, $per_page );
        return [
            'results' => array_map( fn( $h ) => [
                'episode_id'   => $h->id,
                'title'        => $h->title,
                'excerpt'      => $h->highlight,
                'tier_slug'    => $h->tier,
                'episode_type' => $h->type,
                'permalink'    => get_permalink( $h->id ),
            ], $hits->items ),
            'total' => $hits->total,
            'pages' => $hits->pages,
        ];
    },
    10, 6
);
