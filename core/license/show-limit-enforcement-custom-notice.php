<?php
// Show-limit enforcement: site-wide wp-admin notice

// On over-limit: stash the current state so admin_notices can render it.
// Fires from the daily license cron, so we can't render directly — the
// notice hook runs on wp-admin page loads.
add_action( 'benecaster_show_limit_exceeded', function ( array $payload ): void {
    update_option( 'my_theme_show_limit_alert', [
        'active_show_count' => (int) ( $payload['active_show_count'] ?? 0 ),
        'show_limit'        => $payload['show_limit'] ?? null,
        'first_seen_at'     => time(),
    ], false );
} );

// On recovery: clear the stashed state so the notice stops rendering.
// Fires when the license server confirms the site is back under its
// show_limit (upgrade or archive freed capacity).
add_action( 'benecaster_show_limit_recovered', function (): void {
    delete_option( 'my_theme_show_limit_alert' );
} );

// Render on every wp-admin page. The React Shows portfolio's own banner
// renders separately — this is additive, not a replacement.
add_action( 'admin_notices', function (): void {
    $state = get_option( 'my_theme_show_limit_alert' );
    if ( ! is_array( $state ) ) {
        return;
    }
    $active = (int) ( $state['active_show_count'] ?? 0 );
    $limit  = $state['show_limit'];

    printf(
        '<div class="notice notice-error"><p><strong>%s</strong> %s <a href="%s">%s</a></p></div>',
        esc_html__( 'Benecaster:', 'my-theme' ),
        esc_html( sprintf(
            /* translators: 1: active show count, 2: plan show limit */
            __( 'Your site has %1$d shows on a plan that allows %2$d. Some shows have been disabled — upgrade your plan or archive a different show to restore them.', 'my-theme' ),
            $active,
            null === $limit ? 0 : (int) $limit
        ) ),
        esc_url( admin_url( 'admin.php?page=benecaster#/shows' ) ),
        esc_html__( 'Open Shows', 'my-theme' )
    );
} );
