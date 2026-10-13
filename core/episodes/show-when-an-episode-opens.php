<?php
// Tell a Member When a Locked Episode Opens for Their Plan

$show_id = (int) wp_get_post_parent_id( get_the_ID() );
$tier    = benecaster_get_user_tier_for_show( $show_id, get_current_user_id() );
if ( '' !== $tier ) {
    $opens = benecaster_get_episode_available_at( get_the_ID(), $tier );
    if ( null !== $opens && strtotime( $opens . ' UTC' ) > time() ) {
        printf(
            /* translators: %s: date the episode opens */
            esc_html__( 'Opens for your plan on %s', 'my-theme' ),
            esc_html( wp_date( get_option( 'date_format' ), strtotime( $opens . ' UTC' ) ) )
        );
    }
}
