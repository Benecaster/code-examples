<?php
// Keep web-only markup out of the RSS feed

// An interactive embed on episode pages, a plain link in feeds: podcast apps run no JavaScript.
add_filter( 'benecaster_episode_content', function ( string $content, int $episode_id ): string {
    $url = get_permalink( $episode_id );
    if ( \Benecaster\Feed\FeedCompiler::is_compiling() ) {
        return $content . '<p><a href="' . esc_url( $url ) . '">Join the discussion</a></p>';
    }
    return $content . '<div class="my-comments-widget" data-episode="' . (int) $episode_id . '"></div>';
}, 20, 2 );
