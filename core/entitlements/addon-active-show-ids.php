<?php
// List content only from the shows where your add-on is on

add_shortcode( 'my_addon_archive', static function (): string {
    $show_ids = benecaster_addon_active_show_ids( 'benecaster-addon-my-addon' );
    if ( [] === $show_ids ) {
        return ''; // On for no show: render nothing.
    }
    $episodes = get_posts( [
        'post_type'       => 'benecaster_episode',
        'post_status'     => 'publish',
        'post_parent__in' => $show_ids,
        'posts_per_page'  => 20,
    ] );
    $items = array_map(
        static fn( WP_Post $e ): string => '<li><a href="' . esc_url( get_permalink( $e ) ) . '">' . esc_html( get_the_title( $e ) ) . '</a></li>',
        $episodes
    );
    return '<ul class="my-addon-archive">' . implode( '', $items ) . '</ul>';
} );
