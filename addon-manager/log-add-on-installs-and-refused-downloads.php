<?php
// Keep a log of every add-on install, update and refused download

add_action( 'benecaster_manager_addon_installed', function ( string $slug, string $plugin, bool $activated ): void {
    error_log( sprintf( 'Benecaster add-on installed: %s (%s)%s', $slug, $plugin, $activated ? '' : ' — not activated' ) );
}, 10, 3 );

add_action( 'benecaster_manager_addon_updated', function ( string $slug, string $plugin, string $version ): void {
    error_log( sprintf( 'Benecaster add-on updated: %s to %s', $slug, $version ) );
}, 10, 3 );

add_action( 'benecaster_manager_package_rejected', function ( string $package, WP_Error $error, array $context ): void {
    wp_mail( get_option( 'admin_email' ), 'A Benecaster download was refused', sprintf(
        "%s (%s)\n%s\n%s",
        $context['slug'] ?: 'unknown product',
        $context['action'] ?: 'download',
        $error->get_error_code(),
        $package
    ) );
}, 10, 3 );
