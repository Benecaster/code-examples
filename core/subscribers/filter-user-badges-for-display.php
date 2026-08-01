<?php
// Append, hide, or reorder a subscriber's badges per show

add_filter( 'benecaster_user_badges', function ( array $badges, int $user_id, ?int $show_id ): array {
    // Hide a specific badge from public-facing display on one show.
    if ( $show_id === 42 ) {
        $badges = array_values( array_filter(
            $badges,
            fn( $row ) => $row->label !== 'Internal Tester'
        ) );
    }

    // Append a synthetic badge sourced from an add-on (e.g. forum reputation).
    $badges[] = (object) [
        'label'     => sprintf( 'Reputation: %d', my_forum_get_reputation( $user_id ) ),
        'icon_slug' => 'star',
        'color'     => '#FFD700',
        'source'    => 'manual',
    ];

    return $badges;
}, 10, 3 );
