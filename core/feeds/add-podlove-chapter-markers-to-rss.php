<?php
// Add Podlove chapter markers to RSS

add_filter(
    'benecaster_rss_extra_item_tags',
    function ( array $tags, int $episode_id, int $show_id ): array {
        $chapters_url = (string) get_post_meta( $episode_id, '_my_chapters_json_url', true );
        if ( '' === $chapters_url ) {
            return $tags;
        }
        $tags['podcast:chapters'] = [
            'value'      => '',
            'attributes' => [
                'url'  => esc_url_raw( $chapters_url ),
                'type' => 'application/json+chapters',
            ],
        ];
        return $tags;
    },
    10,
    3
);
