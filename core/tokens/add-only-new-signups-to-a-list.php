<?php
// Add only new signups to your mailing list, not imported or synced listeners

add_action( 'benecaster_token_generated', function ( int $token_id, int $user_id, int $show_id ): void {
    if ( benecaster_is_import() || benecaster_is_member_sync() ) {
        return;
    }

    // Decide now, then queue: a job run later always hears false from both.
    wp_schedule_single_event( time(), 'my_list_subscribe', [ $user_id, $show_id ] );
}, 10, 3 );
