<?php
// Restyle or change a sponsor message where its tag shows it

// Label every sponsor read on the episode page.
add_filter( 'benecaster_sponsor_manager_message_output', function ( string $html, int $message_id, int $episode_id, array $atts ): string {
    return '<p class="sponsor-label">' . esc_html__( 'Sponsored', 'my-theme' ) . '</p>' . $html;
}, 10, 4 );
