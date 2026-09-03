<?php
// Surface the customer's pending referral credit in an add-on dashboard widget

// In an add-on dashboard widget callback:
add_action( 'wp_dashboard_setup', function (): void {
    $code = benecaster_get_referral_code();
    if ( null === $code ) {
        return; // License server has not (yet) supplied a referral code.
    }
    wp_add_dashboard_widget(
        'my_addon_referral_status',
        __( 'Benecaster referral status', 'my-addon' ),
        static function () use ( $code ): void {
            $link    = benecaster_get_referral_link() ?? "https://benecaster.com/ref/{$code}";
            $balance = benecaster_get_referral_credit_cents();

            printf(
                '<p>%s <code>%s</code></p>',
                esc_html__( 'Your referral link:', 'my-addon' ),
                esc_html( $link )
            );

            if ( $balance > 0 ) {
                printf(
                    '<p>%s</p>',
                    esc_html( sprintf(
                        /* translators: %s: formatted dollar amount */
                        __( '%s in referral credit pending application to a future renewal.', 'my-addon' ),
                        '$' . number_format( $balance / 100, 2 )
                    ) )
                );
            } else {
                esc_html_e( 'No referral credit pending.', 'my-addon' );
            }
        }
    );
} );
