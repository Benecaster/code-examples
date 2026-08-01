<?php
// Replace or suppress the RSS link output

// On episode pages, prepend a small "RSS" badge before the link.
add_filter(
    'benecaster_rss_link_output',
    function ( string $html, string $feed_url, array $atts ): string {
        if ( is_singular( 'benecaster_episode' ) ) {
            return '<span class="my-rss-badge">RSS</span>' . $html;
        }
        return $html;
    },
    10, 3
);
