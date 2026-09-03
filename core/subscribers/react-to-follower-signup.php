<?php
// React to a free follower signup

// Tag a follower in your ESP without enabling the Email Integrations add-on.
add_action( 'benecaster_follower_signed_up', function ( int $user_id, int $show_id, string $tier_slug ): void {
    $user = get_userdata( $user_id );
    if ( ! $user instanceof \WP_User ) {
        return;
    }
    my_esp_tag_subscriber( $user->user_email, 'benecaster_follower' );
}, 10, 3 );

// Use a show-specific follower slug so the feed URL reads sensibly per show.
add_filter( 'benecaster_follower_tier_slug', function ( string $tier_slug, int $show_id ): string {
    $show = get_post( $show_id );
    return $show ? $show->post_name . '-follower' : $tier_slug;
}, 10, 2 );
