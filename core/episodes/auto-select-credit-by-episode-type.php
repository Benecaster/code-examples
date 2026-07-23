<?php
// Auto-select a credit template based on episode type.

/**
 * Pre-select the guest interview credit template when the episode has a guest.
 * Falls back to the podcaster's own default if no guest is attached.
 */
add_filter(
    'benecaster_credit_options',
    function ( array $credits, int $show_id, int $episode_id ): array {
        $guest_id = (int) get_post_meta( $episode_id, '_my_plugin_episode_guest', true );
        if ( $guest_id <= 0 ) {
            return $credits; // No guest — keep existing defaults.
        }

        // Find the guest interview template by name convention.
        $guest_credit_name = 'Guest Interview Credits';
        foreach ( $credits as &$credit ) {
            // Clear any existing default first.
            $credit['is_default'] = false;
        }
        unset( $credit );

        foreach ( $credits as &$credit ) {
            if ( $credit['name'] === $guest_credit_name ) {
                $credit['is_default'] = true;
                break;
            }
        }
        unset( $credit );

        return $credits;
    },
    10,
    3
);
