<?php
// Sync show creation to external CRM

add_action( 'benecaster_show_created', function ( int $show_id ) {
    my_crm_create_show( [
        'wp_id'    => $show_id,
        'name'     => get_the_title( $show_id ),
        'feed_url' => get_post_meta( $show_id, '_benecaster_show_feed_slug', true ),
    ] );
} );

add_action( 'benecaster_show_updated', function ( int $show_id, array $changed_fields ) {
    if ( empty( $changed_fields ) ) {
        return;
    }
    if ( in_array( 'title', $changed_fields, true ) ) {
        my_crm_update_show_name( $show_id, get_the_title( $show_id ) );
    }
}, 10, 2 );

add_action( 'benecaster_show_deleted', function ( int $show_id ) {
    my_crm_delete_show( $show_id );
} );
