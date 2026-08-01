<?php
// Replace or wrap the assembled Supporter Wall HTML

add_filter( 'benecaster_supporter_wall_output', function ( string $html, int $show_id, array $subscribers, array $atts ): string {
    if ( empty( $subscribers ) ) {
        return ''; // Suppress the wall entirely when empty
    }
    $count   = count( $subscribers );
    $heading = sprintf( '<h2 class="wall-heading">%d Supporters</h2>', $count );
    return '<section class="my-supporter-wall-section">' . $heading . $html . '</section>';
}, 10, 4 );
