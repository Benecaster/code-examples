<?php
// Inject a step into the setup wizard from an add-on

add_filter( 'benecaster_setup_wizard_steps', function ( array $steps ): array {
    // Insert after the 'subscription' step.
    $insert_after = array_search( 'subscription', array_column( $steps, 'id' ), true );
    if ( false !== $insert_after ) {
        array_splice( $steps, $insert_after + 1, 0, [[
            'id'        => 'my-addon-config',
            'component' => 'MyAddonWizardStep',
            'required'  => false,
            'condition' => 'bridge_connected',
        ]] );
    }
    return $steps;
} );
