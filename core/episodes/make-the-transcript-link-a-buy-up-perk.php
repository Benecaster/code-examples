<?php
// Make the transcript link a buy-up perk

add_filter( 'benecaster_show_episode_transcript', function ( bool $show, int $episode_id, ?int $user_id ): bool {
    $my_transcripts_buyup_id = 12; // Memberships → Buy-ups → your "Transcripts" buy-up.
    return $show && $user_id && benecaster_user_has_buyup( $user_id, $my_transcripts_buyup_id, (int) wp_get_post_parent_id( $episode_id ) );
}, 10, 3 );
