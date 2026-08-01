<?php
// Count paying subscribers correctly from benecaster_tokens

global $wpdb;

$tokens   = $wpdb->prefix . 'benecaster_tokens';
$tier_map = $wpdb->prefix . 'benecaster_tier_map';

// Count paying subscribers for a single show.
$count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.show_id = %d AND t.status = 'active'
       AND t.token_type = 'subscriber' AND tm.is_free_tier = 0",
    $show_id
) );

// Same pattern, site-wide — drives the daily license-server subscriber_count.
$site_count = (int) $wpdb->get_var(
    "SELECT COUNT(*) FROM {$tokens} t
     INNER JOIN {$tier_map} tm
         ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
     WHERE t.status = 'active'
       AND t.token_type = 'subscriber' AND tm.is_free_tier = 0"
);
