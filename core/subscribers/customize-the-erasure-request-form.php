<?php
// Customise the erasure request form, or put it on your privacy page

add_filter( 'benecaster_erasure_request_output', function ( string $html, array $atts, string $state ): string {
    if ( 'sent' === $state ) {
        // Same message for every address, known or not. Keep it that way.
        return $html . '<p class="my-erasure-note">' . esc_html__( 'We aim to complete requests within 30 days.', 'my-theme' ) . '</p>';
    }
    return $html;
}, 10, 3 );
