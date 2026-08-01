<?php
// Replace or suppress the platform links output

// Wrap the platform links in a themed "listen on" card.
add_filter(
    'benecaster_platform_links_output',
    function ( string $html, array $links, array $atts ): string {
        return '<div class="my-listen-card"><h3>Listen on</h3>' . $html . '</div>';
    },
    10, 3
);
