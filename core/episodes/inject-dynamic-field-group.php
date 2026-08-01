<?php
// Inject a dynamically generated field group

add_filter( 'benecaster_field_groups', function ( array $groups, string $cpt_slug ): array {
    if ( 'benecaster_episode' !== $cpt_slug ) {
        return $groups;
    }

    if ( ! function_exists( 'my_sponsor_plugin_active' ) || ! my_sponsor_plugin_active() ) {
        return $groups;
    }

    $groups[] = [
        'id'            => 'synthetic_sponsor',
        'name'          => __( 'Sponsor Info', 'my-sponsor-plugin' ),
        'cpt_slug'      => $cpt_slug,
        'display_order' => 999,
        'field_count'   => 0,
        'fields'        => [
            [
                'id'            => 'synthetic_sponsor_name',
                'group_id'      => 'synthetic_sponsor',
                'field_label'   => __( 'Sponsor Name', 'my-sponsor-plugin' ),
                'field_key'     => 'sponsor_name',
                'field_type'    => 'text',
                'display_order' => 0,
                'options'       => null,
                'required'      => false,
            ],
        ],
    ];

    return $groups;
}, 10, 2 );
