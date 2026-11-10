<?php
// Switch Off, or Restyle, the Feed Landing Page

add_filter( 'benecaster_feed_landing_page_enabled', function ( bool $enabled, int $show_id ): bool {
    return 42 === $show_id ? false : $enabled;
}, 10, 2 );
