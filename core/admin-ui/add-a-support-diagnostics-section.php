<?php
// Add a Support Diagnostics Section

add_filter( 'benecaster_support_diagnostics_sections', function ( array $sections ): array {
    $sections[] = [
        'id'     => 'my-addon-health',
        'title'  => __( 'My Add-on Health', 'my-addon' ),
        'render' => function () {
            // Echo your own markup — this is called with no arguments.
            echo '<p>' . esc_html( my_addon_get_last_sync_status() ) . '</p>';
        },
    ];
    return $sections;
} );
