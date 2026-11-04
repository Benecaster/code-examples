<?php
// Annotate episode references with tracked redirect URLs

add_filter( 'benecaster_episode_references', function ( array $references, int $episode_id, int $show_id, string $context = 'page' ): array {
    // Runs on the episode page ('page'), in the feed ('rss') and in emails ('email').
    // Keyed by reference_id, which stays the same across every episode that cites the reference.
    $tracked = (array) get_option( 'myplugin_tracked_references', [] );
    foreach ( $references as &$ref ) {
        $reference_id = (int) ( $ref['reference_id'] ?? 0 );
        if ( isset( $tracked[ $reference_id ] ) ) {
            // Mark where the click came from; the redirect handler reads it.
            $ref['url'] = add_query_arg( 'src', $context, $tracked[ $reference_id ] );
        }
    }
    unset( $ref );
    return $references;
}, 10, 4 );
