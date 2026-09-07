<?php
// Boot an add-on against the per-show gate

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    // Nothing here knows which show is being rendered yet, so this is the
    // one place a site-wide question is the right one: is it worth wiring
    // up at all on this install?
    if ( ! benecaster_addon_is_active_for_any_show( 'benecaster-addon-my-addon' ) ) {
        return;
    }

    $container->make( \MyAddon\MyClass::class )->register();
} );

// ...and gate the actual behaviour per show, where the show is known.
add_filter( 'benecaster_episode_description', function ( string $html, int $episode_id ): string {
    $show_id = (int) get_post_meta( $episode_id, '_benecaster_episode_show_id', true );

    if ( ! benecaster_addon_is_active( 'benecaster-addon-my-addon', $show_id ) ) {
        return $html;
    }

    return $html . my_addon_render_extra( $episode_id );
}, 10, 2 );
