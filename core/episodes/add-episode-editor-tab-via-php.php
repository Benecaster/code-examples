<?php
// Add a tab to the episode editor

add_filter( 'benecaster_episode_editor_tabs', function ( array $tabs, int $show_id ): array {
    $tabs[] = [
        'id'     => 'my-addon',
        'label'  => __( 'My Add-on', 'my-addon' ),
        'icon'   => 'puzzle',
        'add_on' => 'benecaster-addon-my-addon', // hidden on shows where it is not active
    ];
    return $tabs;
}, 10, 2 );

// The panel is drawn in JavaScript:
// window.BenecasterExtensions.registerFill( 'BenecasterEpisodeEditorTab_my-addon', MyPanel );
