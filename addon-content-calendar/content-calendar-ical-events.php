<?php
// Add to or change the entries in a show's Content Calendar iCal export and subscription feed

add_filter( 'benecaster_content_calendar_ical_events', function ( array $events, int $show_id, string $context ): array {
    foreach ( my_sponsor_deadlines( $show_id ) as $deadline ) {
        $events[] = [
            'uid'         => 'my-sponsors-deadline-' . $deadline->id . '@' . wp_parse_url( home_url(), PHP_URL_HOST ),
            'summary'     => 'Sponsor read due: ' . $deadline->sponsor,
            'description' => '',
            'date'        => $deadline->date, // Site time.
            'time'        => null,
            'url'         => '',
            'cancelled'   => false,
            'stamp'       => gmdate( 'Y-m-d H:i:s' ),
        ];
    }
    return $events;
}, 10, 3 );
