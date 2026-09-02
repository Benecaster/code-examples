<?php
/**
 * Which subscriber count is the paying one
 */

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

$count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.show_id = %d AND t.status = 'active'
       AND t.token_type = 'subscriber' AND tm.is_free_tier = 0",
    $show_id
) );

// Same pattern, site-wide — the figure behind the daily licence report.
$site_count = (int) $wpdb->get_var(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.status = 'active'
       AND t.token_type = 'subscriber' AND tm.is_free_tier = 0"
);
