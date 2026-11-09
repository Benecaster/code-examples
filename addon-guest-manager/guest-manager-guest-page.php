<?php
// Restyle, extend or override a guest's public page

// Leave trailers off guest pages.
add_filter( 'benecaster_guest_manager_guest_page_data', static function ( array $page ): array {
    $page['episodes'] = array_values( array_filter(
        $page['episodes'],
        static fn( array $e ): bool => 'trailer' !== get_post_meta( $e['episode_id'], '_benecaster_episode_type', true )
    ) );
    return $page;
}, 10, 2 );
