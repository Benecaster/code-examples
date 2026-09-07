<?php
// Check whether a Benecaster add-on is available for a show

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    // Nothing here knows which show is being rendered yet, so this is the
    // one place the install-wide question is the right one: is it worth
    // wiring up at all on this install?
    if ( ! benecaster_addon_is_active_for_any_show( 'analytics-dashboard' ) ) {
        return;
    }

    $container->make( \MyPlugin\DigestSection::class )->register();
} );

// ...and check per show, where the show is known.
add_filter( 'benecaster_analytics_digest_sections', function ( array $sections, string $type, int $show_id, array $data ): array {
    if ( ! benecaster_addon_is_active( 'analytics-dashboard', $show_id ) ) {
        return $sections;
    }

    $sections[] = my_plugin_build_section( $show_id, $data );

    return $sections;
}, 10, 4 );
