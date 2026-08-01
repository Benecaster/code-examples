<?php
// Add a tab to the episode editor via PHP filter (Tier 1)

add_filter( 'benecaster_episode_editor_tabs', function ( array $tabs ): array {
    $tabs[] = [
        'id'       => 'my-addon',
        'label'    => __( 'My Add-on', 'my-addon' ),
        'icon'     => 'puzzle',
        'add_on'   => 'my-addon',
        'sections' => [
            [
                'id'     => 'my-settings',
                'label'  => __( 'Settings', 'my-addon' ),
                'fields' => [
                    [
                        'id'      => '_my_addon_field',
                        'type'    => 'toggle',
                        'label'   => __( 'Enable feature', 'my-addon' ),
                        'default' => false,
                        'meta'    => true,
                    ],
                ],
            ],
        ],
    ];
    return $tabs;
} );
