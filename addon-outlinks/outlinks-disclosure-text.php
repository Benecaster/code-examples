<?php
// Change or remove the affiliate disclosure line on episode pages

add_filter( 'benecaster_outlinks_disclosure_text', function ( string $text, int $show_id ): string {
    if ( 12 === $show_id ) {
        return ''; // This show discloses in its own episode template.
    }
    return $text . ' ' . __( 'Thank you for supporting the show.', 'my-theme' );
}, 10, 2 );
