<?php
// List a guest's episodes from another add-on

// A guest's episodes in a search result, each locked or not for the viewer.
$episodes = function_exists( 'benecaster_guest_manager_get_guest_episodes' )
    ? benecaster_guest_manager_get_guest_episodes( $guest_id )
    : [];
foreach ( $episodes as $row ) {
    $can_access = benecaster_user_can_access_episode( $row['episode_id'], get_current_user_id() );
    benecaster_get_template_part( 'archive/episode-card', [ 'episode_id' => $row['episode_id'], 'can_access' => $can_access ] );
}
