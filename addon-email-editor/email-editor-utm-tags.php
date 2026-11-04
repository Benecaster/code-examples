<?php
// Change the UTM tags on a broadcast's or an episode notification's links

add_filter( 'benecaster_email_utm_params', function ( array $params, string $email_type, ?int $episode_id, ?int $show_id, string $link ): array {
    if ( 'unsubscribe' === $link ) {
        return []; // Leave these links untagged.
    }

    $params['utm_term'] = 'my-term';

    return $params;
}, 10, 5 );
