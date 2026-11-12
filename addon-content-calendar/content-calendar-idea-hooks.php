<?php
// Run your own code when a Content Calendar idea is saved, deleted or rearranged

add_action( 'benecaster_content_calendar_after_delete_idea', function ( array $idea, string $context ): void {
    if ( 'promote' === $context ) {
        my_log( sprintf( 'Idea "%s" went on show %d\'s calendar.', $idea['title'], $idea['show_id'] ) );
    }
}, 10, 2 );
