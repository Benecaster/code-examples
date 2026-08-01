<?php
// Override a single episode template part from a child theme

// Child theme: wp-content/themes/my-child/benecaster/episode/title.php
// This file replaces the plugin's episode/title.php automatically — no PHP code needed.
// Just create the file and Benecaster will use it.

// To confirm the override is active (e.g. in a theme options panel or debug page):
$override_path = benecaster_locate_template( 'episode/title' );
if ( $override_path ) {
    echo 'Theme override active: ' . esc_html( $override_path );
}

// To get the path that would be loaded (override or plugin default):
$path = benecaster_get_template_path( 'episode/title' );
