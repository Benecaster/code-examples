<?php
// Which subscriber count is the paying one

// Almost always: the public helpers. Both exclusions applied for you.
$count      = benecaster_count_paying_subscribers( $show_id );
$site_count = benecaster_count_paying_subscribers_site_wide();

// For contrast — every active token, followers and free-tier members
// included. An audience size, not a paying count.
$audience = benecaster_get_subscriber_count( $show_id );

// Only when WordPress is not loaded at all: a SQL client, a reporting
// tool, a migration script that never boots WP. Note BOTH conditions,
// and BOTH tier tables.
global $wpdb;

$tokens     = $wpdb->prefix . 'benecaster_tokens';
$tier_map   = $wpdb->prefix . 'benecaster_tier_map';          // external bridges
$mem_tiers  = $wpdb->prefix . 'benecaster_membership_tiers';  // built-in membership

// The exempt types, read from core so the query can't fall behind it.
$exempt       = \Benecaster\Token\TokenRepository::PAYING_EXEMPT_TOKEN_TYPES;
$placeholders = implode( ', ', array_fill( 0, count( $exempt ), '%s' ) );

// LEFT JOIN BOTH tier tables. A show uses one or the other, so an INNER JOIN
// to either one silently drops every token belonging to the other kind.
$joins = "LEFT JOIN {$tier_map} tm
              ON tm.show_id = t.show_id AND tm.internal_tier_slug = t.tier_slug
          LEFT JOIN {$mem_tiers} mt
              ON mt.show_id = t.show_id AND mt.tier_slug = t.tier_slug";

// "Paying" = not an exempt type, and not free according to whichever tier
// table holds a row. A tier NEITHER table knows about counts as paying:
// never under-count, because that is what the podcaster is billed on.
$paying = "t.token_type NOT IN ( {$placeholders} )
           AND ( CASE
                   WHEN tm.id IS NULL AND mt.id IS NULL THEN 0
                   ELSE LEAST( COALESCE(tm.is_free_tier, 1), COALESCE(mt.is_free, 1) )
                 END ) = 0";

// Count paying subscribers for a single show.
$count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t {$joins}
     WHERE t.show_id = %d AND t.status = 'active' AND {$paying}",
    $show_id,
    ...$exempt
) );

// Same pattern, site-wide — drives the daily license-server subscriber_count.
$site_count = (int) $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM {$tokens} t {$joins}
     WHERE t.status = 'active' AND {$paying}",
    ...$exempt
) );

// Outside PHP (a SQL client, a reporting tool): write the deny list
// literally, keep both LEFT JOINs, and re-check it whenever Benecaster
// updates: t.token_type NOT IN ('follower', 'purchaser')
