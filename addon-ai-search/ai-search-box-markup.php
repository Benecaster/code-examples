<?php
// Change or wrap the AI Search box's markup

add_filter( 'benecaster_ai_search_output', function ( string $html, array $atts ): string {
    return '<section class="my-ask-the-archive"><h2>' . esc_html__( 'Ask the archive', 'my-theme' ) . '</h2>' . $html . '</section>';
}, 10, 2 );
