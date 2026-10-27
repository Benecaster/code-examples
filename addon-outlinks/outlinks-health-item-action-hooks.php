<?php
// Run your own code before and after each Link Health action — dismiss, restore, fix a URL, unlink, track

add_action( 'benecaster_outlinks_health_item_action_after', function ( string $action, array $item, array $args, array $result ): void {
    if ( 'update_url' === $action ) {
        error_log( sprintf( 'Link Health: post %d now links to %s instead of %s', $args['post_id'], $args['url'], $args['old_url'] ) );
    }
}, 10, 4 );
