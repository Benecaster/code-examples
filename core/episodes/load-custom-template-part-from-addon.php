<?php
// Ship template parts from an add-on

add_action( 'benecaster_boot', function (): void {
    benecaster_register_template_directory( plugin_dir_path( __FILE__ ) . 'templates' );
} );

// Anywhere in the add-on — resolves through the full chain, so a theme
// override of the same part still wins.
benecaster_get_template_part( 'guest/profile-card', [ 'guest_id' => $guest_id ] );
