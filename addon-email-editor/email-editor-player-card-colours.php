<?php
// Use a custom brand colour for the play button on one show's player cards

add_filter( 'benecaster_player_card_image_args', function ( array $args, int $episode_id ): array {
    if ( 12 === (int) wp_get_post_parent_id( $episode_id ) ) {
        $args['play_button_color'] = '#ffcc00';
        $args['overlay_opacity']   = 0.25;
    }
    return $args;
}, 10, 2 );
