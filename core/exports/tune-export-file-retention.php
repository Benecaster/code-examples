<?php
// Adjust or Disable Export File Auto-Deletion

// wp-config.php — hard override to 30 days for a site that generates
// large monthly exports and wants to keep the last two on disk.
define( 'BENECASTER_EXPORT_TTL_DAYS', 30 );

// mu-plugins — per-site policy toggle, e.g. disable when the site's
// backup solution already snapshots the uploads directory nightly.
add_filter( 'benecaster_export_ttl_days', function ( int $days ): int {
    return defined( 'MY_SITE_HAS_EXTERNAL_BACKUP' ) && MY_SITE_HAS_EXTERNAL_BACKUP
        ? 0
        : $days;
} );
