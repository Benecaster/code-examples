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
                sprintf( __( 'Feed redirect for "%s" has expired', 'my-addon' ), get_the_title( $show_id ) ),
                __( 'Your <itunes:new-feed-url> redirect tag has been removed from your podcast feed.', 'my-addon' )
            );
        }
    }
}, 10, 2 );
