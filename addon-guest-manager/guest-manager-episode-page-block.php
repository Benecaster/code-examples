<?php
// Style, replace or hide Guest Manager's Guests in this episode block

// Put the guests in a card grid of your own, keeping Guest Manager's data and order.
add_filter( 'benecaster_episode_page_block_guests', static function ( string $html, int $episode_id ): string {
    if ( '' === $html ) {
        return $html; // No linked guest, or Guest Manager off for this show.
    }
    $cards = array_map(
        static fn( array $g ): string => sprintf( '<li><a href="%s">%s</a></li>', esc_url( $g['profile_url'] ), esc_html( $g['name'] ) ),
        benecaster_guest_manager_get_episode_guests( $episode_id )
    );
    return '<ul class="my-guest-grid">' . implode( '', $cards ) . '</ul>';
}, 10, 2 );
