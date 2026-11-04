<?php
// Tell which send an email belongs to

add_filter( 'benecaster_email_body_html', function ( string $html, string $type, ?int $user_id, ?int $show_id, int $related_id ): string {
    if ( 0 === $related_id || null === $user_id ) {
        return $html; // A one-off, a preview, or not sent to an account.
    }

    return $html . my_open_pixel( $type, $related_id, $user_id );
}, 10, 5 );

// Group your own sends under one id, such as an episode's.
benecaster_send_email( $user_id, 'my_episode_notice', '', '', [
    'show_id'    => $show_id,
    'related_id' => $episode_id,
] );
