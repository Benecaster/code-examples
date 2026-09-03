<?php
// Enumerate WP User IDs Eligible for a Broadcast Audience

// Built-in audiences — including per-tier, which needs no callback.
$paying = benecaster_find_audience_user_ids( $show_id, 'paying' );
$gold   = benecaster_find_audience_user_ids( $show_id, 'tier:gold' );

foreach ( $gold as $user_id ) {
    $user = get_userdata( $user_id );
    // Hand off to the email queue, an ESP API call, an export sheet, etc.
}

// A genuinely custom audience: everyone who joined in the last 30 days.
add_filter( 'benecaster_broadcast_audience_user_ids', function (
    array  $user_ids,
    string $audience,
    int    $show_id
): array {
    // Guard first. Without this you rewrite every audience at once.
    if ( 'joined-last-30-days' !== $audience ) {
        return $user_ids;
    }

    global $wpdb;

    // created_at is stored in the site's timezone, so build the cutoff in
    // the same timezone rather than in UTC — an install in UTC+13 would
    // otherwise silently move the window by half a day.
    $cutoff = wp_date( 'Y-m-d H:i:s', time() - 30 * DAY_IN_SECONDS );

    $rows = $wpdb->get_col( $wpdb->prepare(
        "SELECT DISTINCT user_id FROM {$wpdb->prefix}benecaster_tokens
         WHERE show_id = %d AND status = 'active' AND created_at >= %s",
        $show_id,
        $cutoff
    ) );

    return array_map( 'intval', (array) $rows );
}, 10, 3 );
