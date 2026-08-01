<?php
// Invalidate an external cache or CDN when an episode is unpublished

add_action( 'benecaster_episode_unpublished', function ( int $episode_id, int $show_id ) {
    // Purge the episode's CDN cache so the locked-content page is served.
    my_cdn_purge_url( get_permalink( $episode_id ) );

    // Remove from search index.
    my_search_index_delete( $episode_id );
}, 10, 2 );
