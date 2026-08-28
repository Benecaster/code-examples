<?php
// Restyle or reword the Explicit badge

// 1. Replace "Explicit" with a short "E" everywhere the badge renders.
add_filter( 'benecaster_explicit_badge_label', function ( string $label, string $mode ): string {
    return 'clean' === $mode ? $label : 'E';
}, 10, 2 );

// 2. Restyle without touching templates — the class list already carries
//    two modifiers (--{mode} + --context-{surface}), so plain CSS handles
//    most cases. The HTML filter is the escape hatch when class-only styling
//    is not enough (e.g. injecting an <svg> icon for aria-hidden purposes).
add_filter( 'benecaster_explicit_badge_html', function ( string $html, int $episode_id, int $show_id, string $mode, string $context ): string {
    if ( 'clean' === $mode ) {
        return $html; // leave the empty string alone
    }
    return sprintf(
        '<span class="my-explicit" role="img" aria-label="%s"><svg aria-hidden="true"></svg><span class="visually-hidden">%s</span></span>',
        esc_attr__( 'Explicit content', 'my-theme' ),
        esc_html__( 'Explicit', 'my-theme' )
    );
}, 10, 5 );

// 3. Force the badge on a specific episode without touching the stored
//    meta — useful for a one-off override during a special series.
add_filter( 'benecaster_explicit_badge_mode', function ( string $mode, int $episode_id, int $show_id ): string {
    return 12345 === $episode_id ? 'yes' : $mode;
}, 10, 3 );
