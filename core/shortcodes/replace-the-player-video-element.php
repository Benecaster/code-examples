<?php
// Replace the episode player's video with your own player

add_filter( 'benecaster_player_output', function ( string $html, int $episode_id ): string {
    if ( ! str_contains( $html, 'benecaster-player--video' ) ) {
        return $html; // Audio player — leave it alone.
    }
    $show_id = (int) wp_get_post_parent_id( $episode_id );
    $url     = (string) apply_filters(
        'benecaster_episode_video_url',
        (string) get_post_meta( $episode_id, '_benecaster_video_url', true ),
        $episode_id,
        $show_id
    );
    return '<div class="benecaster-player benecaster-player--video" data-episode-id="' . esc_attr( (string) $episode_id ) . '"'
        . ' data-show-id="' . esc_attr( (string) $show_id ) . '">'
        . '<video class="my-plyr" playsinline controls src="' . esc_url( $url ) . '"></video>'
        . '</div>';
}, 10, 2 );
