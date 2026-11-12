<?php
// Restyle a guest's publications, or change or remove the affiliate line

add_filter( 'benecaster_guest_manager_affiliate_disclosure', static function ( string $text, int $guest_id ): string {
    return __( 'We may earn a commission from links marked as affiliate links.', 'my-theme' );
}, 10, 2 );
