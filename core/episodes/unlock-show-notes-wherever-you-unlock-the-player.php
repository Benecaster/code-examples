<?php
// Unlock the show notes wherever you unlock the player

$my_trial = function ( bool $show, int $episode_id, ?int $user_id ): bool {
    return $show || ( $user_id && my_trial_is_active( $user_id ) );
};
add_filter( 'benecaster_show_episode_player',  $my_trial, 10, 3 );
add_filter( 'benecaster_show_episode_content', $my_trial, 10, 3 );
