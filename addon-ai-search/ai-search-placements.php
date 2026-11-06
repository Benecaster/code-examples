<?php
// Style the AI Search box's placements, or change what their results show

// Show excerpts in sidebar boxes too, but never dates in a modal.
add_filter( 'benecaster_ai_search_result_fields', function ( array $fields, string $placement ): array {
    if ( 'sidebar' === $placement ) {
        return [ 'title', 'excerpt' ];
    }
    return 'modal' === $placement ? array_values( array_diff( $fields, [ 'date' ] ) ) : $fields;
}, 10, 2 );
