<?php
// Enumerate WP User IDs Eligible for a Broadcast Audience, with Follower Support

$repo  = \Benecaster\Plugin::instance()->make( \Benecaster\Token\TokenRepository::class );
$ids   = $repo->find_audience_user_ids( $show_id, 'paying' );

foreach ( $ids as $user_id ) {
    $user = get_userdata( $user_id );
    // Hand off to the email queue, an ESP API call, an export sheet, etc.
}

// Register a custom per-tier audience slug.
add_filter( 'benecaster_broadcast_audience_user_ids', function (
    array $user_ids,
    string $audience,
    int $show_id
): array {
    if ( 0 !== strpos( $audience, 'tier:' ) ) {
        return $user_ids;
    }
    $tier_slug = substr( $audience, 5 );

    // Start from the supported audience lookup, then narrow it to one tier.
    $repo = \Benecaster\Plugin::instance()->make( \Benecaster\Token\TokenRepository::class );

    return array_values( array_filter(
        $repo->find_audience_user_ids( $show_id, 'all' ),
        fn( int $user_id ): bool
            => $tier_slug === benecaster_get_user_tier_for_show( $show_id, $user_id )
    ) );
}, 10, 3 );
