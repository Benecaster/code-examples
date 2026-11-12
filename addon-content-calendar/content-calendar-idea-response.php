<?php
// Add to what the Content Calendar REST API answers for an idea

add_filter( 'benecaster_content_calendar_idea_response', function ( array $data, array $idea ): array {
    $data['author'] = get_the_author_meta( 'display_name', $idea['created_by'] );
    return $data;
}, 10, 2 );
