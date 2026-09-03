<?php
// Bridge the catalog/entitlement slug split when cross-referencing the two systems

use Benecaster\License\LicenseManager;

$license = new LicenseManager();
$pricing = get_transient( 'benecaster_pricing_data' );

foreach ( $pricing['addons'] ?? [] as $addon ) {
    $entitlement_slug = LicenseManager::catalog_slug_to_entitlement_slug( $addon['slug'] );
    $owned            = $license->addon_is_active( $entitlement_slug );
    // Render purchase or "owned" UI based on $owned.
}
