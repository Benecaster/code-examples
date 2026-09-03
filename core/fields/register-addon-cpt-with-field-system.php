<?php
// Register an add-on CPT with the custom field system

// PHP — register the CPT at add-on boot
add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    benecaster_register_field_cpt( 'benecaster_guest', __( 'Guest', 'benecaster-guest-manager' ) );
} );

// React — fetch and save field values in a guest editor panel
// (see recipe page for full TSX example using useFieldValues / useSaveFieldValues)
