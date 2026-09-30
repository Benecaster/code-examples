<?php
// Send every subscribe link to one page

add_filter(
    'benecaster_signup_url',
    function ( string $url, int $show_id, int $user_id ): string {
        $page = get_page_by_path( 'join' );

        if ( ! $page ) {
            return $url; // Always fall back: never return '' or a guess.
        }

        // $user_id is 0 for a public QR code. Only personalise when a
        // member is actually in context.
        if ( 0 !== $user_id ) {
            return add_query_arg( 'upgrade', $user_id, get_permalink( $page ) );
        }

        return get_permalink( $page );
    },
    10,
    3
);
