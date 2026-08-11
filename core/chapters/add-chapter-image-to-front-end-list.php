<?php
// Add chapter image to the front-end chapter list

// Safe filter usage — modify row shape (drop, reorder, rewrite data).
add_filter( 'benecaster_episode_chapters', function ( array $chapters, int $episode_id, int $show_id ): array {
    // Example: hide "Sponsors" chapter rows entirely for logged-in subscribers.
    if ( is_user_logged_in() ) {
        $chapters = array_values( array_filter(
            $chapters,
            fn( $c ) => stripos( $c['title'] ?? '', 'sponsor' ) === false
        ) );
    }
    return $chapters;
}, 10, 3 );

/*
 * To display chapter images on the episode page, override the template:
 *
 *   {theme}/benecaster/episode/chapters.php
 *
 * Inside the loop, the $chapters array (after this filter) contains each
 * row's image_id. Render it with:
 *
 *   if ( ! empty( $chapter['image_id'] ) ) {
 *       echo wp_get_attachment_image( (int) $chapter['image_id'], [ 40, 40 ] );
 *   }
 *
 * Placing <img> markup directly in the title field will not work — the
 * template calls esc_html( $title ) before rendering, which will escape the
 * tag into literal &lt;img ...&gt; in the browser.
 */
