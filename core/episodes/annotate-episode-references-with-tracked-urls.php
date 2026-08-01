<?php
// Annotate episode references with tracked redirect URLs

add_filter( 'benecaster_episode_references', function ( array $references, int $episode_id, int $show_id ): array {
    return array_map( function ( array $ref ) use ( $episode_id ) {
        $tracked_url = get_post_meta( $episode_id, '_outlinks_tracked_' . $ref['id'], true );
        if ( $tracked_url ) {
            $ref['tracked_url'] = $tracked_url;
        }
        return $ref;
    }, $references );
}, 10, 3 );
