<?php
// Render an initials-based avatar when site-wide Gravatar is disabled

add_filter( 'benecaster_avatar_fallback', function ( ?string $url, int $user_id ): ?string {
    if ( $user_id <= 0 ) {
        return $url;
    }
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return $url;
    }
    $initial = strtoupper( substr( $user->display_name ?: $user->user_login, 0, 1 ) );
    return 'https://avatars.my-cdn.example/initials/' . rawurlencode( $initial ) . '.png';
}, 10, 2 );
