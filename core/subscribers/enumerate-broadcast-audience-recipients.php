<?php
// Enumerate WP user IDs eligible for a broadcast audience, with follower support

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

    global $wpdb;
    $rows = $wpdb->get_col( $wpdb->prepare(
        "SELECT DISTINCT user_id FROM {$wpdb->prefix}benecaster_tokens
         WHERE show_id = %d AND status = 'active' AND tier_slug = %s",
        $show_id,
        $tier_slug
    ) );
    return array_map( 'intval', (array) $rows );
}, 10, 3 );
