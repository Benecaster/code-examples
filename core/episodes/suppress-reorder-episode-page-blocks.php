<?php
// Suppress or reorder Episode Page blocks for a specific episode

// Hide the subscribe CTA on episodes tagged 'free-preview':
add_filter( 'benecaster_episode_page_blocks', function ( array $blocks, int $episode_id, int $show_id ): array {
    if ( has_term( 'free-preview', 'post_tag', $episode_id ) ) {
        return array_filter( $blocks, fn( $b ) => ( $b['slug'] ?? '' ) !== 'subscribe_cta' );
    }
    return $blocks;
}, 10, 3 );

// Or suppress episode_nav on the most recent episode:
add_filter( 'benecaster_episode_page_blocks', function ( array $blocks, int $episode_id, int $show_id ): array {
    $latest = get_posts( [
        'post_type'      => 'benecaster_episode',
        'post_parent'    => $show_id,
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ] );
    if ( isset( $latest[0] ) && (int) $latest[0] === $episode_id ) {
        return array_filter( $blocks, fn( $b ) => ( $b['slug'] ?? '' ) !== 'episode_nav' );
    }
    return $blocks;
}, 10, 3 );
