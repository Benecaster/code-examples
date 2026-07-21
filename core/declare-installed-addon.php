// Tell the Add-ons screen that this add-on plugin is loaded
add_action( 'benecaster_boot', function (): void {
    add_filter( 'benecaster_installed_addons', static function ( array $slugs ): array {
        $slugs[] = 'benecaster-addon-guest-manager';
        return $slugs;
    } );
} );
