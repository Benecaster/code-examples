<?php
// React when a show's redirect tag is automatically removed

add_action( 'benecaster_redirect_expiry_run', function ( int $count, array $show_ids ): void {
    if ( $count === 0 ) {
        return;
    }
    foreach ( $show_ids as $show_id ) {
        $owner_email = get_post_meta( $show_id, '_benecaster_show_author_email', true );
        if ( $owner_email ) {
            benecaster_mail(
                $show_id,
                $owner_email,
                // get_the_title() returns HTML (Dave&#8217;s Q&#038;A); this is plain text.
                sprintf( __( 'Feed redirect for "%s" has expired', 'my-addon' ), html_entity_decode( get_the_title( $show_id ), ENT_QUOTES, 'UTF-8' ) ),
                __( 'Your <itunes:new-feed-url> redirect tag has been removed from your podcast feed.', 'my-addon' )
            );
        }
    }
}, 10, 2 );
