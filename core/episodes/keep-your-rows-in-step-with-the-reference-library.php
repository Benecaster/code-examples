<?php
// Keep your own rows in step with the reference library

add_action(
    'benecaster_reference_library_item_updated',
    function ( int $item_id, int $show_id, array $old, array $new ): void {
        // Only the destination matters to a redirect; a label edit does not.
        if ( ( $old['url'] ?? null ) === ( $new['url'] ?? null ) ) {
            return;
        }

        my_addon_repoint_redirect( $item_id, (string) ( $new['url'] ?? '' ) );
        my_addon_clear_link_check_cache( $item_id );
    },
    10,
    4
);

add_action(
    'benecaster_reference_library_item_deleted',
    function ( int $item_id, int $show_id ): void {
        // The library item and every episode reference citing it are already
        // gone. Retire the redirect rather than leave it pointing at a
        // reference nobody can see any more.
        my_addon_retire_redirect( $item_id );
    },
    10,
    2
);
