<?php
// Override locked content message per tier

add_filter(
    'benecaster_locked_content_message',
    function ( string $html, int $episode_id, int $show_id, string $current_tier ): string {
        if ( '' === $current_tier ) {
            return '<p>This episode is available to Premium subscribers. <a href="/subscribe/">Subscribe now →</a></p>';
        }
        if ( 'basic' === $current_tier ) {
            return sprintf(
                '<p>You\'re on <strong>Basic</strong>. This episode requires <strong>Premium</strong>. <a href="%s">Upgrade →</a></p>',
                esc_url( home_url( '/account/upgrade/' ) )
            );
        }
        return $html;
    },
    10,
    4
);
