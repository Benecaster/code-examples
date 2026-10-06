<?php
// Turn off, or restyle, Benecaster's base styles for its shortcodes

// functions.php — the theme styles Benecaster's shortcodes itself.
add_filter( 'benecaster_shortcode_base_styles', '__return_false' );
