<?php
// Override teaser content with a chapter preview

add_filter( 'benecaster_teaser_content', function ( string $html, int $episode_id, string $source ): string {
    $first_chapter = get_post_meta( $episode_id, '_my_addon_first_chapter_title', true );
    if ( ! $first_chapter ) {
        return $html; // fall back to default teaser
    }
    return sprintf(
        '<p class="my-chapter-teaser">%s <em>%s</em></p>',
        esc_html__( 'First chapter:', 'my-addon' ),
        esc_html( $first_chapter )
    );
}, 10, 3 );
