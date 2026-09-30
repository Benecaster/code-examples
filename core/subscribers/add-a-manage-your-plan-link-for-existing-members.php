<?php
// Add a "manage your plan" link for members who already have one

add_filter(
    'benecaster_subscribe_current_membership',
    function ( string $html, array $membership, int $show_id ): string {
        // Only the people who actually have something to manage.
        if ( 'paid' !== $membership['state'] ) {
            return $html;
        }

        $account = get_page_by_path( 'my-account' ); // your [benecaster_account] page
        if ( ! $account ) {
            return $html;
        }

        return $html . sprintf(
            '<p><a href="%s">%s</a></p>',
            esc_url( get_permalink( $account ) ),
            esc_html__( 'Manage your plan', 'my-plugin' )
        );
    },
    10,
    3
);
