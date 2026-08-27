<?php
// Embed a show QR code on a marketing page

// The show ID is the one thing this snippet needs from you. Every show
// displays a click-to-copy #{id} chip in its admin header and on its card
// in Benecaster → Shows. On a page template, read it from a custom field
// or the URL rather than hard-coding it.
$show_id = 12;

if ( ! $show_id ) {
    return; // Nothing to render.
}

$qr_url    = rest_url( 'benecaster/v1/shows/' . (int) $show_id . '/qr.png' );
$show_name = get_the_title( $show_id );

printf(
    '<img src="%s" alt="%s" width="240" height="240" />',
    esc_url( $qr_url ),
    esc_attr( sprintf( 'Subscribe to %s', $show_name ) )
);
