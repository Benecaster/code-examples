<?php
// Change or add to the transcript the add-on shows on the site

add_filter( 'benecaster_transcript_display_html', static function ( string $html, int $episode_id ): string {
    return '<h2 class="my-transcript-heading">' . esc_html__( 'Read along', 'my-theme' ) . '</h2>' . $html;
}, 10, 2 );
