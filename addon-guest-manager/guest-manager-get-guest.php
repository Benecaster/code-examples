<?php
// Read one guest by id from another add-on

// A transcript speaker mapped to a guest: $mapped = [ 'guest_id' => 42, 'name' => 'Alice Smith' ].
function my_addon_speaker_name( array $mapped, int $episode_id ): string {
    $show_id = (int) get_post_field( 'post_parent', $episode_id );
    $guest   = function_exists( 'benecaster_guest_manager_get_guest' )
        && function_exists( 'benecaster_addon_is_active' )
        && benecaster_addon_is_active( 'benecaster-addon-guest-manager', $show_id )
        ? benecaster_guest_manager_get_guest( (int) $mapped['guest_id'] )
        : null;

    return null !== $guest ? $guest['name'] : (string) $mapped['name'];
}

// Offer the episode's own guests first in a mapping list, then search the roster
// with GET /wp-json/benecaster-guest-manager/v1/guests?search=… (recipe guest-manager-guests-rest, manage_options).
$suggested = function_exists( 'benecaster_guest_manager_get_episode_guests' )
    ? benecaster_guest_manager_get_episode_guests( $episode_id )
    : [];
