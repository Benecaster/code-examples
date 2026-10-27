<?php
// Carry per-reference tracking to the new show when an episode moves

add_action( 'benecaster_episode_references_moved', function ( int $episode_id, int $from_show_id, int $to_show_id, array $map ): void {
    foreach ( $map as $old_item_id => $new_item_id ) {
        $row = my_tracking_row( $from_show_id, (int) $old_item_id );
        if ( null === $row || null !== my_tracking_row( $to_show_id, (int) $new_item_id ) ) {
            continue; // Nothing tracked, or the destination item is already tracked (two items may share a value).
        }
        my_create_tracking_row( $to_show_id, (int) $new_item_id, $row );
    }
}, 10, 4 );
