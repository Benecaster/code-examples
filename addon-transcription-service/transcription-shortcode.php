<?php
// Put an episode's transcript on any page, and tell locked-out visitors how to read it

// A five-line preview, linking to the episode page for the rest:
echo do_shortcode( '[benecaster_transcript episode_id="42" mode="preview"]' );

// A read-along box that follows the player on the same page:
echo do_shortcode( '[benecaster_player episode_id="42"][benecaster_transcript episode_id="42" mode="scrollable"]' );

// Visitors the visibility excludes: a sign-up note instead of nothing.
add_filter( 'benecaster_transcript_locked_html', static function ( string $html, int $episode_id ): string {
    return '<p class="my-transcript-locked">' . esc_html__( 'Members can read along with every episode.', 'my-theme' ) . '</p>';
}, 10, 2 );
