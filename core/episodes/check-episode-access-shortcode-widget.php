<?php
// Check episode access in a shortcode or widget

// In a shortcode callback or template:
$episode_id = get_the_ID();
$show_id    = (int) get_post_meta( $episode_id, '_benecaster_show_id', true );

if ( benecaster_user_can_access_episode( $episode_id, $show_id ) ) {
    // May play it — a public episode, or one this person's plan or purchase opens.
    echo '<audio src="' . esc_url( get_post_meta( $episode_id, '_benecaster_audio_url', true ) ) . '" controls></audio>';
} elseif ( true === benecaster_user_has_active_membership( $show_id ) ) {
    // A member whose plan does not include this episode — show an upgrade prompt.
    echo '<p>' . esc_html__( 'Upgrade your subscription to access this episode.', 'my-addon' ) . '</p>';
} else {
    // Not a member (false), or membership could not be confirmed (null) — show the subscribe form.
    echo do_shortcode( '[benecaster_subscribe show_id="' . $show_id . '"]' );
}
