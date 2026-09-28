<?php
// Show or hide content based on whether a subscriber owns a buy-up

// Inside a theme template part (e.g. episode/single.php override).
if ( benecaster_user_has_buyup( 0, $transcripts_buyup_id, $show_id ) ) {
    // Render the transcript download block.
    echo do_shortcode( '[my_transcript_download episode="' . $episode_id . '"]' );
} else {
    // Point everyone else to the Extras section of their account page.
    echo '<p>' . esc_html__( 'Add transcripts from the Extras section of your account page.', 'my-theme' ) . '</p>';
}
