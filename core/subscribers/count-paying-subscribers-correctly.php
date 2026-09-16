<?php
// Which subscriber count is the paying one

// Almost always: the public helpers. Both exclusions applied for you.
$count      = benecaster_count_paying_subscribers( $show_id );
$site_count = benecaster_count_paying_subscribers_site_wide();

// For contrast — every active token, followers and free-tier members
// included. An audience size, not a paying count.
$audience = benecaster_get_subscriber_count( $show_id );

// Only when WordPress is not loaded at all: a SQL client, a reporting
// tool, a migration script that never boots WP. Note BOTH conditions.
global $wpdb;

$tokens   = $wpdb->prefix . 'benecaster_tokens';
$tier_map = $wpdb->prefix . 'benecaster_tier_map';

// The exempt types, read from core so the query can't fall behind it.
$exempt       = \Benecaster\Token\TokenRepository::PAYING_EXEMPT_TOKEN_TYPES;
$placeholders = implode( ', ', array_fill( 0, count( $exempt ), '%s' ) );

$count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.show_id = %d AND t.status = 'active'
       AND t.token_type NOT IN ( {$placeholders} ) AND tm.is_free_tier = 0",
    $show_id,
    ...$exempt
) );

// Same pattern, site-wide — the figure behind the daily licence report.
$site_count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.status = 'active'
       AND t.token_type NOT IN ( {$placeholders} ) AND tm.is_free_tier = 0",
    ...$exempt
) );

// Outside PHP (a SQL client, a reporting tool): write the deny list
// literally and re-check it whenever Benecaster updates —
// t.token_type NOT IN ('follower')
