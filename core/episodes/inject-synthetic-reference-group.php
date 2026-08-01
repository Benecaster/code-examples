<?php
// Inject a synthetic reference group from an add-on

add_filter( 'benecaster_reference_groups', function ( array $groups, int $show_id ): array {
    if ( ! my_addon_is_active_for_show( $show_id ) ) {
        return $groups;
    }
    array_unshift( $groups, [
        'id'            => 0,
        'name'          => __( 'Tracked Links', 'my-addon' ),
        'display_order' => -1,
    ] );
    return $groups;
}, 10, 2 );
