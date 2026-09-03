<?php
// Send a Benecaster email type from add-on code

add_action( 'benecaster_episode_published', function ( int $episode_id, int $show_id ): void {
    foreach ( benecaster_find_audience_user_ids( $show_id, 'paying' ) as $user_id ) {
        $queue_id = benecaster_send_email(
            $user_id,
            'my_episode_notification',
            /* translators: %s: episode title */
            sprintf( __( 'New episode: %s', 'my-addon' ), get_the_title( $episode_id ) ),
            'my-addon/episode-notification',
            [
                'show_id'       => $show_id,
                'episode_title' => get_the_title( $episode_id ),
                'episode_url'   => get_permalink( $episode_id ),
            ]
        );

        // 0 means suppressed or failed — most often an opt-out, which is
        // not an error and must not be retried.
        if ( 0 === $queue_id ) {
            continue;
        }
    }
}, 10, 2 );
