<?php
// Show or hide a show's public episode pages from add-on code

use Benecaster\Show\ShowMeta;

// Lock a show to the private feed for 30 days after publish, then reveal.
add_action( 'benecaster_show_created', function ( int $show_id ): void {
    $meta = new ShowMeta( $show_id );
    $meta->set_episode_single_pages_disabled( true );
    $meta->set_episode_archive_disabled( true );

    wp_schedule_single_event( time() + 30 * DAY_IN_SECONDS, 'my_addon_reveal_show', [ $show_id ] );
} );

add_action( 'my_addon_reveal_show', function ( int $show_id ): void {
    $meta = new ShowMeta( $show_id );
    $meta->set_episode_single_pages_disabled( false );
    $meta->set_episode_archive_disabled( false );
} );
