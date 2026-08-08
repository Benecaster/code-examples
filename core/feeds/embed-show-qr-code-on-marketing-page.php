<?php
// Embed a show QR code on a marketing page

// On single-show installs use the auto-resolver; on multi-show installs
// pass the show ID explicitly (e.g. from a page custom field or the URL).
$show_id = benecaster_get_sole_show_id(); // returns null when 0 or > 1 show exists

if ( ! $show_id ) {
    return; // No show resolved — bail silently.
}

$qr_url    = rest_url( 'benecaster/v1/shows/' . (int) $show_id . '/qr.png' );
$show_name = get_the_title( $show_id );

printf(
    '<img src="%s" alt="%s" width="240" height="240" />',
    esc_url( $qr_url ),
    esc_attr( sprintf( 'Subscribe to %s', $show_name ) )
);
