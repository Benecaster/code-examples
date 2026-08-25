<?php
// Adjust or Disable Export File Auto-Deletion

// ---------------------------------------------------------------------------
// Option 1 — hard override in wp-config.php.
//
// This is the operator path: read BEFORE the filter, so a third-party add-on
// cannot raise it. Set to 0 to disable auto-deletion entirely.
//
// Add this line to wp-config.php — it is commented out here because this file
// is an example, and defining the constant from a dropped-in snippet would
// override the site's own wp-config value.
// ---------------------------------------------------------------------------

// define( 'BENECASTER_EXPORT_TTL_DAYS', 30 );

// ---------------------------------------------------------------------------
// Option 2 — runtime filter, e.g. in an mu-plugin.
//
// Default is 7. Return 0 to disable auto-deletion; negative values clamp to 0.
// Here: disable the sweep when the site's own backup solution already
// snapshots the uploads directory nightly.
//
// NOTE: this filter is NOT called at all when BENECASTER_EXPORT_TTL_DAYS is
// defined. If this callback appears to do nothing, check wp-config.php first.
// ---------------------------------------------------------------------------

add_filter( 'benecaster_export_ttl_days', function ( int $days ): int {
    return defined( 'MY_SITE_HAS_EXTERNAL_BACKUP' ) && MY_SITE_HAS_EXTERNAL_BACKUP
        ? 0
        : $days;
} );
