<?php
// Add something below the show notes on every episode page, even when the notes are empty

add_action( 'benecaster_after_episode_content_area', function ( int $episode_id, int $show_id, string $user_tier, bool $can_access ): void {
    if ( ! $can_access ) {
        return;
    }
    $note = get_post_meta( $episode_id, 'my_sponsor_note', true );
    if ( $note !== '' ) {
        echo '<aside class="my-sponsor-note">' . esc_html( $note ) . '</aside>';
    }
}, 10, 4 );
