<?php
// Get the image an episode's video shows before playback, for a theme or another add-on

// A theme's episode card: the video's poster, or the artwork, at card size.
$image = function_exists( 'benecaster_video_podcast_enhanced_get_episode_poster_url' )
    ? benecaster_video_podcast_enhanced_get_episode_poster_url( $episode_id, 'medium_large' )
    : benecaster_get_episode_artwork( $episode_id );

if ( '' !== $image ) {
    printf( '<img src="%s" alt="" loading="lazy">', esc_url( $image ) );
}
