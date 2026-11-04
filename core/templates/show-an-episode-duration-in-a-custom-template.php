<?php
// Show an episode duration in a custom template

// In a theme template, inside a loop over benecaster_episode posts.
$duration = function_exists( 'benecaster_format_duration' )
    ? benecaster_format_duration( (string) get_post_meta( get_the_ID(), '_benecaster_duration', true ) ) // 00:47:23 → 0:47, 01:02:03 → 1:02
    : '';
if ( $duration !== '' ) {
    printf( '<span class="my-episode-duration">%s</span>', esc_html( $duration ) );
}
