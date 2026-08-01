<?php
// Programmatically stamp a credit on episode save

/**
 * Auto-apply the show's default credit when a new episode is created.
 * Respects the benecaster_credit_options filter — if an add-on pre-selects
 * a different template for this episode, that template is applied.
 */
add_action(
    'benecaster_episode_created',
    function ( int $episode_id, int $show_id ): void {
        $episode = get_post( $episode_id );
        if ( ! $episode || ! in_array( $episode->post_status, [ 'draft', 'publish' ], true ) ) {
            return;
        }

        benecaster_apply_default_credit( $episode_id );
    },
    10,
    2
);
