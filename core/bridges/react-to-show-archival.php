<?php
// Fire add-on side effects when a show is archived or restored

add_action( 'benecaster_show_archived', function ( int $show_id ): void {
    // Farewell email to subscribers whose access is about to break.
    $recipients = get_show_subscriber_emails( $show_id );
    wp_mail( $recipients, __( 'Feed archived', 'my-addon' ), '…' );

    // Clear any add-on caches keyed on the show.
    wp_cache_delete( "my_addon_show_{$show_id}", 'my_addon' );
} );

add_action( 'benecaster_show_unarchived', function ( int $show_id ): void {
    // Re-warm caches so the first subscriber poll after restore is fast.
    prime_my_addon_show_cache( $show_id );
} );
