<?php
// Tell a locked visitor which plan opens an episode

function my_locked_line( int $episode_id ): string {
    $show_id = benecaster_resolve_show_id( (int) wp_get_post_parent_id( $episode_id ) );
    if ( 0 === $show_id || benecaster_user_can_access_episode( $episode_id, $show_id ) ) {
        return ''; // nothing to explain
    }

    $openers = benecaster_get_episode_access_tiers( $episode_id, $show_id );
    $tiers   = array_values( array_filter( $openers, static fn( array $o ): bool => 'tier' === $o['kind'] ) );

    if ( 1 === count( $openers ) && 1 === count( $tiers ) ) {
        /* translators: %s: a tier name. */
        $text = sprintf( __( 'Available to %s subscribers', 'my-theme' ), $tiers[0]['name'] );
    } else {
        // Several tiers, a buy-up, or an outright purchase Benecaster does not list.
        $text = __( 'Available to members', 'my-theme' );
    }

    return sprintf(
        '<p class="locked">%s — <a href="%s">%s</a></p>',
        esc_html( $text ),
        esc_url( benecaster_get_signup_url( $show_id, get_current_user_id() ) ),
        esc_html__( 'Join', 'my-theme' )
    );
}
