<?php
// Let a non-editor into wp-admin

// Let shop customers keep their WooCommerce account pages in wp-admin,
// while podcast subscribers are still sent to the Benecaster account page.
add_filter(
    'benecaster_block_subscriber_wpadmin',
    function ( bool $should_block, int $user_id ): bool {
        $user = get_userdata( $user_id );

        if ( $user && in_array( 'customer', (array) $user->roles, true ) ) {
            return false;
        }

        return $should_block;
    },
    10,
    2
);

// Or, on a single-show site: only redirect people who actually hold a tier
// on that show, and leave every other non-editor alone.
add_filter(
    'benecaster_block_subscriber_wpadmin',
    function ( bool $should_block, int $user_id ): bool {
        $show_id = benecaster_get_sole_show_id();

        if ( null === $show_id ) {
            return $should_block; // Multi-show install — no single answer.
        }

        // Returns '' when the user has no active token on that show.
        return $should_block
            && '' !== benecaster_get_user_tier_for_show( $show_id, $user_id );
    },
    10,
    2
);
