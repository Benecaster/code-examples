<?php
// Add to what the Content Calendar REST API answers for a content item

add_filter( 'benecaster_content_calendar_item_response', function ( array $data, array $item ): array {
    $data['scheduler_status'] = my_social_scheduler_status_for( $item['id'] );
    return $data;
}, 10, 2 );
