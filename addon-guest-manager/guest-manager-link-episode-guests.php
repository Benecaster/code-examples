<?php
// Link, unlink or reorder an episode's guests from code, as the episode editor's selector does

// Keep a "featuring" line in your own episode meta, refreshed whenever the selector changes the guests.
add_action( 'benecaster_guest_manager_after_change_episode_guests', static function ( int $episode_id ): void {
    $names = array_column( benecaster_guest_manager_get_episode_guests( $episode_id ), 'name' );
    update_post_meta( $episode_id, '_my_featuring', implode( ', ', $names ) );
} );
