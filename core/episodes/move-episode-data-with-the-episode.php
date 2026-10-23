<?php
// Keep your plugin's per-show episode data with an episode that moves show

add_action( 'benecaster_episode_move_after', function ( int $episode_id, int $from_show_id, int $to_show_id ): void {
    global $wpdb;
    $wpdb->update(
        $wpdb->prefix . 'my_sponsor_slots',
        [ 'show_id' => $to_show_id ],
        [ 'episode_id' => $episode_id, 'show_id' => $from_show_id ],
        [ '%d' ],
        [ '%d', '%d' ]
    );
}, 10, 3 );

add_filter( 'benecaster_episode_move_blockers', function ( array $blockers, int $episode_id ): array {
    if ( my_store_sells_episode( $episode_id ) ) {
        $blockers[] = [
            'type'  => 'my_store_sale',
            'label' => __( 'This episode is for sale in My Store. Remove it from the sale first.', 'my-store' ),
        ];
    }
    return $blockers;
}, 10, 2 );
