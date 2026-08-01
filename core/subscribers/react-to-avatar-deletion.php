<?php
// Invalidate caches or sync to external systems when a subscriber removes their avatar

add_action( 'benecaster_avatar_deleted', function ( int $user_id, int $attachment_id ): void {
    wp_cache_delete( 'avatar_url_' . $user_id, 'my-addon' );
    my_crm_clear_profile_picture( $user_id );
}, 10, 2 );
