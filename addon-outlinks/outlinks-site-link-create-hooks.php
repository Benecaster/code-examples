<?php
// Run your own code when a site-wide Outlinks link is created

add_action( 'benecaster_outlinks_site_link_create_after', function ( int $redirect_id, string $url, string $slug ): void {
    error_log( sprintf( 'Outlinks site-wide link %d: /go/%s -> %s', $redirect_id, $slug, $url ) );
}, 10, 3 );
