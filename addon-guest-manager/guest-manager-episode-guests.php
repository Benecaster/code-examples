<?php
// Read an episode's guests from another add-on

// "Featuring Alice Smith and Bob Jones", each linked to their website when they have one.
$guests = function_exists( 'benecaster_guest_manager_get_episode_guests' )
    ? benecaster_guest_manager_get_episode_guests( $episode_id )
    : [];

$names = array_map(
    static fn( array $g ): string => '' !== $g['website']
        ? '<a href="' . esc_url( $g['website'] ) . '">' . esc_html( $g['name'] ) . '</a>'
        : esc_html( $g['name'] ),
    $guests
);

if ( [] !== $names ) {
    echo esc_html__( 'Featuring', 'my-addon' ) . ' ' . wp_sprintf( '%l', $names );
}
