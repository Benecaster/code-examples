<?php
// Run your own code when moving an episode copies its tracked links to the new show

add_action( 'benecaster_outlinks_redirect_move_copy_after', function ( int $source_id, int $new_id, int $episode_id, int $from_show_id, int $to_show_id ): void {
    error_log( sprintf( 'Episode %d moved to show %d: redirect %d copied as %d', $episode_id, $to_show_id, $source_id, $new_id ) );
}, 10, 5 );
