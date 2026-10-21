<?php
// Play subscribers their tier's audio in your own theme template

// {theme}/benecaster/episode/player.php, or any template with an episode ID.
if ( benecaster_user_can_access_episode( $episode_id, $show_id ) ) {
    $src = benecaster_get_episode_audio_url( $episode_id );
    if ( '' !== $src ) {
        printf( '<audio controls preload="metadata" src="%s"></audio>', esc_url( $src ) );
    }
}
