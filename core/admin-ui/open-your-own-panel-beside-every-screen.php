<?php
// Open your own panel beside every Benecaster screen with a shortcut

add_filter( 'benecaster_admin_shell_panels', static function ( array $panels ): array {
    $panels[] = [
        'id'       => 'my-lookup',
        'label'    => __( 'Lookup', 'my-addon' ),
        'add_on'   => 'my-addon',
        'scope'    => 'any_show',      // A tool for the podcaster themself. Leave it out for anything about the selected show.
        'shortcut' => 'alt+shift+l',  // mod = Cmd on a Mac, Ctrl elsewhere. Copy, paste, find, bold… are refused.
    ];
    return $panels;
} );

// The panel is drawn in JavaScript:
// window.BenecasterExtensions.registerFill( 'BenecasterShellPanel_my-lookup', MyLookup );
