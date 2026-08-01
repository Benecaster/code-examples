<?php
// Flush full-page caches when a per-show Supporter Wall is enabled or disabled

function bc_flush_supporter_wall_pages( int $show_id ): void {
    // Generic WP transient + page-cache plugin hooks.
    delete_transient( 'my_theme_supporter_wall_' . $show_id );

    // Common page-cache plugins.
    if ( function_exists( 'wp_cache_clear_cache' ) ) { wp_cache_clear_cache(); }    // WP Super Cache
    if ( function_exists( 'rocket_clean_post' ) )    { rocket_clean_post( $show_id ); } // WP Rocket
}
add_action( 'benecaster_supporter_wall_enabled',  'bc_flush_supporter_wall_pages' );
add_action( 'benecaster_supporter_wall_disabled', 'bc_flush_supporter_wall_pages' );
