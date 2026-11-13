<?php
// Read or save an episode's Subscriber notification, and run code when it is saved

// Post to the team chat when someone marks an episode's listeners as told.
add_action( 'benecaster_podcast_workflow_after_save_subscriber_notification', function ( int $episode_id, bool $notified, string $notes, int $show_id ): void {
    if ( $notified ) {
        my_plugin_post_to_chat( sprintf( 'Listeners told about %s', get_the_title( $episode_id ) ) );
    }
}, 10, 4 );
