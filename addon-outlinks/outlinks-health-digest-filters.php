<?php
// Change the subject or body of the Link Health email digest, or skip one

add_filter( 'benecaster_outlinks_health_digest_body', function ( string $html, array $new_items, int $total_broken ): string {
    // Only email about tracked links; image and page-link breakages wait for the Link Health page.
    $redirects = array_filter( $new_items, fn( array $item ): bool => 'redirect' === $item['kind'] );
    if ( [] === $redirects ) {
        return '';
    }
    return $html . '<p>' . esc_html__( 'Fix tracked links first: they are in your show notes.', 'my-plugin' ) . '</p>';
}, 10, 3 );
