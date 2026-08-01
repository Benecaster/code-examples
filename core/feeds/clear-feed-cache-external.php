<?php
// Trigger a Feed Cache Clear from External Code

// From an mu-plugin — clear the cache after your custom bulk update.
add_action( 'admin_notices', function (): void {
    if ( ! current_user_can( 'manage_options' ) || empty( $_GET['my_flush_feeds'] ) ) {
        return;
    }
    // Option A: emit the standard action; FeedCache handles the rest.
    do_action( 'benecaster_clear_feed_cache' );

    // Option B: purge the object-cache group directly when you already
    // know the exact (show, tier) tuple you invalidated.
    $show_id   = 42;
    $tier_slug = 'gold';
    wp_cache_delete( "feed:{$show_id}:{$tier_slug}", 'benecaster_feed' );

    printf(
        '<div class="notice notice-success"><p>%s</p></div>',
        esc_html__( 'Feed cache cleared.', 'my-mu-plugin' )
    );
} );
