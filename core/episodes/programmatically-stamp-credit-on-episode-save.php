<?php
// Programmatically stamp a credit on episode save.

/**
 * Auto-apply the show's default credit when a new episode is created.
 * Respects the benecaster_credit_options filter — if an add-on pre-selects
 * a different template for this episode, that template is applied, not the
 * raw stored default.
 */
add_action(
    'benecaster_episode_created',
    function ( int $episode_id, int $show_id ): void {
        // Only auto-stamp episodes created as draft or publish — skip imports.
        $episode = get_post( $episode_id );
        if ( ! $episode || ! in_array( $episode->post_status, [ 'draft', 'publish' ], true ) ) {
            return;
        }

        benecaster_apply_default_credit( $episode_id );
    },
    10,
    2
);

/**
 * WP-CLI command to stamp the default credit on all episodes that don't
 * already have one. Run: wp eval-file stamp-credits.php --show_id=42
 */
$show_id = (int) ( $args['show_id'] ?? 0 );
if ( $show_id <= 0 ) {
    WP_CLI::error( '--show_id is required.' );
}

$episodes = get_posts( [
    'post_type'      => 'benecaster_episode',
    'post_status'    => [ 'draft', 'publish' ],
    'posts_per_page' => -1,
    'post_parent'    => $show_id,
    'meta_query'     => [
        [
            'key'     => '_benecaster_stamped_credit',
            'compare' => 'NOT EXISTS',
        ],
    ],
] );

foreach ( $episodes as $episode ) {
    $ok = benecaster_apply_default_credit( $episode->ID );
    WP_CLI::log( sprintf(
        '%s episode %d (%s)',
        $ok ? 'Stamped' : 'Skipped (no default credit)',
        $episode->ID,
        $episode->post_title
    ) );
}
