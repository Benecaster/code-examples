<?php
// Read or set an episode's sponsors, the campaign each is tied to, and their ad positions from code, as the episode editor's Sponsors tab does

// Tell an ad-ops sheet whenever an episode's sponsor line-up or campaigns change.
add_action( 'benecaster_sponsor_manager_after_save_episode_sponsors', function ( int $episode_id, int $show_id, array $sponsors, array $previous ): void {
    $before = array_column( $previous, 'campaign_id', 'sponsor_id' );
    foreach ( $sponsors as $entry ) {
        if ( ( $before[ $entry['sponsor_id'] ] ?? null ) !== $entry['campaign_id'] ) {
            my_adops_log( $show_id, $episode_id, $entry['sponsor_id'], $entry['campaign_id'] );
        }
    }
}, 10, 4 );
