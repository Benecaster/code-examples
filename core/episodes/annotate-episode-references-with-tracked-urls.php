<?php
// Annotate episode references with tracked redirect URLs

add_filter( 'benecaster_episode_references', function ( array $references, int $episode_id, int $show_id ): array {
    // The episode editor loads references over REST; leave the stored URLs alone there.
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return $references;
    }
    // Keyed by reference_id, which stays the same across every episode that cites the reference.
    $tracked = (array) get_option( 'myplugin_tracked_references', [] );
    foreach ( $references as &$ref ) {
        $reference_id = (int) ( $ref['reference_id'] ?? 0 );
        if ( isset( $tracked[ $reference_id ] ) ) {
            $ref['url'] = $tracked[ $reference_id ];
        }
    }
    unset( $ref );
    return $references;
}, 10, 3 );
