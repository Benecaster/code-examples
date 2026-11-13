<?php
// Read an episode's sponsors, or a sponsor's episodes, from another add-on

// List an episode's sponsors and their positions in another add-on's panel.
if ( function_exists( 'benecaster_sponsor_manager_get_episode_sponsors' ) ) {
    foreach ( benecaster_sponsor_manager_get_episode_sponsors( $episode_id ) as $sponsor ) {
        printf( '<li>%s (%s)</li>', esc_html( $sponsor['company'] ), esc_html( implode( ', ', $sponsor['positions'] ) ) );
    }
}
