<?php
// Inject or reorder social links programmatically

// Pin a newsletter link to the top for every show.
add_filter(
    'benecaster_show_social_links',
    function ( array $links, int $show_id ): array {
        $newsletter_url = get_option( 'my_plugin_newsletter_url_' . $show_id );
        if ( $newsletter_url ) {
            array_unshift( $links, [
                'platform' => 'newsletter',
                'url'      => $newsletter_url,
                'label'    => __( 'Newsletter', 'my-plugin' ),
            ] );
        }
        return $links;
    },
    10, 2
);
