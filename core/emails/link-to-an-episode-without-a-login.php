<?php
// Put a "listen now, no login" link to an episode in your own email

// In your own newsletter loop, per recipient:
$url = benecaster_get_episode_access_url( $user->ID, $episode_id );
if ( '' !== $url ) {
    $url = add_query_arg( [ 'utm_source' => 'my_newsletter', 'utm_medium' => 'email' ], $url );
    $body .= sprintf( '<a href="%s">%s</a>', esc_url( $url ), esc_html__( 'Listen now', 'my-plugin' ) );
}

// Count clicks — fires on the click only, not on later visits the cookie opens.
add_action( 'benecaster_magic_link_validated', function ( int $user_id, int $episode_id, int $show_id ): void {
    update_post_meta( $episode_id, '_my_email_clicks', (int) get_post_meta( $episode_id, '_my_email_clicks', true ) + 1 );
}, 10, 3 );
