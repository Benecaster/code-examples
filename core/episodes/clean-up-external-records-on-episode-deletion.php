<?php
// Clean up external records when an episode is permanently deleted

add_action( 'benecaster_episode_deleted', function ( int $episode_id, int $show_id ) {
    $audio_url = get_post_meta( $episode_id, '_benecaster_audio_url', true );

    my_analytics_delete_episode( $episode_id );

    my_slack_notify( sprintf(
        'Episode deleted: %s (show %d) — audio: %s',
        get_the_title( $episode_id ),
        $show_id,
        $audio_url ?: 'none'
    ) );
}, 10, 2 );
