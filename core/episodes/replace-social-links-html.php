<?php
// Replace the social links HTML entirely

// Wrap social links in a branded container on show pages.
add_filter(
    'benecaster_social_links_output',
    function ( string $html, array $items, array $config ): string {
        if ( is_singular( 'benecaster_show' ) ) {
            return '<div class="my-brand-social">' . $html . '</div>';
        }
        return $html;
    },
    10, 3
);
