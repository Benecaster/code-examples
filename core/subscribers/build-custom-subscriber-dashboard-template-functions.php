// Build a custom subscriber dashboard with template functions
// Register a shortcode you can drop into any page: [my_subscriber_dashboard]
add_shortcode( 'my_subscriber_dashboard', function (): string {
    $user_id = get_current_user_id();
    if ( 0 === $user_id ) {
        return '<p>' . esc_html__( 'Please log in to view your dashboard.', 'my-theme' ) . '</p>';
    }
    global $wpdb;
    $shows = $wpdb->get_col( $wpdb->prepare(
        "SELECT DISTINCT show_id FROM {$wpdb->prefix}benecaster_tokens
         WHERE user_id = %d AND status = 'active'",
        $user_id
    ) );

    ob_start();
    foreach ( array_map( 'intval', (array) $shows ) as $show_id ) {
        $feed_url        = benecaster_get_feed_url( $show_id, $user_id );
        $subscriber_count = benecaster_get_subscriber_count( $show_id );
        printf(
            '<article class="my-show-card"><h3>%s</h3><p>%s</p><code>%s</code></article>',
            esc_html( get_the_title( $show_id ) ),
            esc_html( sprintf( _n( '%s subscriber', '%s subscribers', $subscriber_count, 'my-theme' ), number_format_i18n( $subscriber_count ) ) ),
            esc_html( $feed_url )
        );
        benecaster_get_template_part( 'account/qr-code', [ 'show_id' => $show_id, 'user_id' => $user_id ] );
    }
    return (string) ob_get_clean();
} );
