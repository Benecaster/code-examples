<?php
// Register a custom related-episodes query strategy

add_filter(
    'benecaster_related_episodes_query_types',
    function ( array $types ): array {
        $types['by_series'] = new class implements \Benecaster\Search\BenecasterRelatedEpisodesQueryInterface {
            public function get_label(): string {
                return __( 'Same series', 'my-addon' );
            }

            public function get_results( int $episode_id, int $show_id, array $args ): array {
                $series_id = get_post_meta( $episode_id, '_my_addon_series_id', true );
                if ( ! $series_id ) {
                    return [];
                }
                $count   = (int) ( $args['count'] ?? 5 );
                $exclude = (bool) ( $args['exclude_current'] ?? true );
                $all     = get_posts( [
                    'post_type'   => 'benecaster_episode',
                    'post_status' => 'publish',
                    'post_parent' => $show_id,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                ] );
                $related = [];
                foreach ( $all as $post ) {
                    if ( $exclude && $post->ID === $episode_id ) {
                        continue;
                    }
                    if ( get_post_meta( $post->ID, '_my_addon_series_id', true ) === $series_id ) {
                        $related[] = $post;
                    }
                }
                return $count > 0 ? array_slice( $related, 0, $count ) : $related;
            }
        };
        return $types;
    }
);
