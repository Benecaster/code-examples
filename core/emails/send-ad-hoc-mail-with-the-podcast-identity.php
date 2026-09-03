<?php
// Send one-off mail with the podcast's identity

add_action( 'my_addon_export_finished', function ( int $show_id, string $download_url ): void {
    benecaster_mail(
        $show_id,
        (string) get_option( 'admin_email' ),
        __( 'Your export is ready', 'my-addon' ),
        sprintf(
            /* translators: %s: download URL */
            '<p>' . esc_html__( 'Your export is ready: %s', 'my-addon' ) . '</p>',
            esc_url( $download_url )
        ),
        [ 'Reply-To: producer@example.com' ]
    );
}, 10, 2 );
