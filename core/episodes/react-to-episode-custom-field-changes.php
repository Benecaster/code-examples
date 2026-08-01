<?php
// React to episode custom field changes from an add-on

add_action( 'benecaster_episode_field_values_updated', function (
    int   $episode_id,
    int   $show_id,
    array $changed_field_ids
): void {
    foreach ( $changed_field_ids as $field_id ) {
        $value = benecaster_get_field( $field_id, $episode_id );
        my_addon_sync_field( $episode_id, $field_id, $value );
    }
}, 10, 3 );
