<?php
// Track a link that belongs to no show — a guest's book, a sponsor page — and get its /go/ address

// Guest Manager's "Track with Outlinks", from a handler that checked manage_options.
if ( function_exists( 'benecaster_outlinks_site_link' ) ) {
    $link = benecaster_outlinks_site_link( $publication['url'], [ 'slug' => sanitize_title( $publication['title'] ) ] );
    if ( is_wp_error( $link ) && 'benecaster_outlinks_slug_taken' === $link->get_error_code() ) {
        $link = benecaster_outlinks_site_link( $publication['url'], [ 'slug' => $link->get_error_data()['suggestion'] ] );
    }
    if ( ! is_wp_error( $link ) ) {
        $publication['outlinks_id'] = $link['id'];
    }
}

// On the guest page.
$tracked = ! empty( $publication['outlinks_id'] ) && function_exists( 'benecaster_outlinks_get_site_link' )
    ? benecaster_outlinks_get_site_link( (int) $publication['outlinks_id'] )
    : null;
$href = null !== $tracked ? $tracked['go_url'] : $publication['url'];
