<?php
// Add a custom icon to the per-tier badge picker

add_filter( 'benecaster_badge_icons', function ( array $icons ): array {
    $icons['rocket'] = [
        'slug'  => 'rocket',
        'label' => __( 'Rocket', 'my-addon' ),
        'svg'   => '<svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M..."/></svg>',
    ];
    return $icons;
} );
