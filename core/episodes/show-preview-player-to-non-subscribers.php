<?php
// Show a 60-second preview player to non-subscribers

// 1. Tell the template to render the accessible player for everyone.
add_filter( 'benecaster_show_episode_player', function (
    bool    $show,
    int     $episode_id,
    ?int    $user_id,
    ?string $user_tier
): bool {
    // Always show the player — the audio URL swap below limits what they hear.
    return true;
}, 10, 4 );

// 2. Replace the audio URL with a 60-second preview for non-subscribers.
add_filter( 'benecaster_episode_audio_url', function (
    string $url,
    int    $episode_id
): string {
    $user_id = get_current_user_id();
    if ( $user_id > 0 && benecaster_user_can_access_episode( $episode_id, (int) get_post_field( 'post_parent', $episode_id ), $user_id ) ) {
        return $url; // Subscriber gets the full episode.
    }
    // Return a preview URL stored in custom meta (e.g. set by your add-on).
    $preview = get_post_meta( $episode_id, '_my_addon_preview_url', true );
    return $preview !== '' ? (string) $preview : $url;
}, 10, 2 );
