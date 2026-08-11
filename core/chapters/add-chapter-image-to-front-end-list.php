<?php
/**
 * Add chapter image to the front-end chapter list.
 *
 * The front-end chapter list renders timestamp + title per row but does not
 * display the optional chapter image by default — apps that read the
 * <podcast:chapters> JSON endpoint show images, and web display is
 * intentionally minimal. Sites that want images on the page can modify row
 * data via the benecaster_episode_chapters filter, but images must be injected
 * via a template override because the template escapes titles with esc_html().
 *
 * This recipe demonstrates safe row-shape modifications (dropping rows
 * conditionally) and explains the correct approach for adding image markup.
 */

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
 * tag into literal &lt;img …&gt; in the browser.
 */
