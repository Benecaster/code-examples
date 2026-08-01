<?php
// Grant access based on WooCommerce product purchase

// Grant free-preview tagged episodes to all logged-in users.
add_filter( 'benecaster_episode_is_accessible', function( bool $access, int $episode_id, int $user_id, string $tier_slug ): bool {
    if ( $user_id > 0 && has_term( 'free-preview', 'category', $episode_id ) ) {
        return true;
    }
    return $access;
}, 10, 4 );
