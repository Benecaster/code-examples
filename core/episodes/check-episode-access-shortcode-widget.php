<?php
// Check episode access in a shortcode or widget

// In a shortcode callback or template:
$episode_id = get_the_ID();
$show_id    = (int) get_post_meta( $episode_id, '_benecaster_show_id', true );

if ( benecaster_user_can_access_episode( $episode_id, $show_id ) ) {
    // Subscriber with access — render full content.
    echo '<audio src="' . esc_url( get_post_meta( $episode_id, '_benecaster_audio_url', true ) ) . '" controls></audio>';
} else {
    $tier = benecaster_get_user_tier_for_show( $show_id );
    if ( $tier !== '' ) {
        // Logged-in subscriber but wrong tier — show upgrade prompt.
        echo '<p>' . esc_html__( 'Upgrade your subscription to access this episode.', 'my-addon' ) . '</p>';
    } else {
        // Not subscribed — show subscribe CTA.
        echo do_shortcode( '[benecaster_subscribe show_id="' . $show_id . '"]' );
    }
}
