<?php
// Show locked search results, or replace their card

// A members-only card that names the price.
add_filter( 'benecaster_ai_search_locked_result', function ( string $card, int $episode_id, int $user_id, string $cta_html ): string {
    return '<div class="benecaster-ai-search__locked my-locked">'
        . '<strong>' . esc_html( get_the_title( $episode_id ) ) . '</strong> '
        . esc_html__( 'is for members, from $5 a month.', 'my-theme' ) . ' ' . $cta_html
        . '</div>';
}, 10, 4 );
