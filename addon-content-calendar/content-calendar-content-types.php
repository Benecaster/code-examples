<?php
// Read or change a show's Content Calendar content types

// Offer a Podcast Clip type on every show that has not made its own.
add_filter( 'benecaster_content_calendar_content_types', function ( array $types, int $show_id ): array {
    if ( ! in_array( 'custom_podcast_clip', array_column( $types, 'key' ), true ) ) {
        $types[] = [ 'key' => 'custom_podcast_clip', 'name' => 'Podcast Clip', 'color' => '#db2777', 'enabled' => true, 'built_in' => false, 'uses_content' => true, 'content_limit' => 280 ];
    }
    return $types;
}, 10, 2 );
