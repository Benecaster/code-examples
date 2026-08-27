<?php
// Build a custom subscriber dashboard with template functions

// Register a shortcode you can drop into any page: [my_subscriber_dashboard]
add_shortcode( 'my_subscriber_dashboard', function (): string {
    $user_id = get_current_user_id();
    if ( 0 === $user_id ) {
        return '<p>' . esc_html__( 'Please log in to view your dashboard.', 'my-theme' ) . '</p>';
    }

    $shows = get_posts( [
        'post_type'      => 'benecaster_show',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ] );

    ob_start();

    foreach ( $shows as $show_id ) {
        $tier = benecaster_get_user_tier_for_show( $show_id, $user_id );

        // Empty tier means no active subscription to this show — skip it.
        if ( '' === $tier ) {
            continue;
        }

        $feed_url = benecaster_get_feed_url( $user_id, $show_id );

        printf(
            '<article class="my-show-card"><h3>%s</h3><p>%s</p><code>%s</code></article>',
            esc_html( get_the_title( $show_id ) ),
            esc_html( sprintf( __( 'Your plan: %s', 'my-theme' ), $tier ) ),
            esc_html( (string) $feed_url )
        );

        benecaster_get_template_part(
            'account/qr-code',
            [ 'show_id' => $show_id, 'user_id' => $user_id ]
        );
    }

    return (string) ob_get_clean();
} );
