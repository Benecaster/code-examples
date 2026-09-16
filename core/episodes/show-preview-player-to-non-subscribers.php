<?php
// Let visitors who can't hear an episode play a preview clip

// Open the player for locked visitors, but only where a clip exists and the
// episode has a main audio URL. Without one, the player template falls back
// to the episode's embed or video, and that would be the full episode.
add_filter( 'benecaster_show_episode_player', function ( bool $show, int $episode_id ): bool {
    if ( $show ) {
        return true;
    }
    $audio = (string) get_post_meta( $episode_id, '_benecaster_audio_url', true );
    return '' !== $audio && '' !== my_host_preview_url( $episode_id );
}, 20, 2 );

// Swap in the clip for anyone who can't hear the episode, on the web only.
add_filter( 'benecaster_episode_audio_url', function (
    string  $url,
    int     $episode_id,
    ?string $tier_slug = null
): string {
    if ( null !== $tier_slug ) {
        return $url;
    }
    $show_id = (int) get_post_field( 'post_parent', $episode_id );
    if ( benecaster_user_can_access_episode( $episode_id, $show_id ) ) {
        return $url;
    }
    $clip = my_host_preview_url( $episode_id );
    return '' !== $clip ? $clip : $url;
}, 20, 3 );
