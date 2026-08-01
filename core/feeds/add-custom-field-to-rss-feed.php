<?php
// Add a custom field to the RSS feed

add_filter(
    'benecaster_rss_extra_item_tags',
    function ( array $tags, int $episode_id, int $show_id ): array {
        $sponsor = benecaster_get_field( 'sponsors', $episode_id );
        if ( is_string( $sponsor ) && '' !== $sponsor ) {
            $tags['myshow:sponsor'] = $sponsor;
        }
        $count = (int) get_post_meta( $episode_id, '_my_addon_chapter_count', true );
        if ( $count > 0 ) {
            $tags['myshow:chapterCount'] = [
                'value'      => (string) $count,
                'attributes' => [ 'unit' => 'chapters' ],
            ];
        }
        return $tags;
    },
    10,
    3
);
