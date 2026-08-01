<?php
// Conditionally show or hide template parts based on a subscriber's buy-up ownership

// Inside a theme template part (e.g. episode/single.php override).
if ( benecaster_user_has_buyup( 0, $transcripts_buyup_id, $show_id ) ) {
    // Render the transcript download block.
    echo do_shortcode( '[my_transcript_download episode="' . $episode_id . '"]' );
} else {
    // Render the "Add transcripts to your plan" upsell.
    echo do_shortcode( '[benecaster_buyup_upsell buyup="' . $transcripts_buyup_id . '"]' );
}
