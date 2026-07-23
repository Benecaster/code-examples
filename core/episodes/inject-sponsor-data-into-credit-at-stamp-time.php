<?php
// Inject current sponsor promo code into the stamped credit.

/**
 * Inject current sponsor promo code into the stamped credit.
 * Template body must include {{PROMO_CODE}} as a replacement target.
 */
add_filter(
    'benecaster_credit_before_stamp',
    function ( string $text, string $credit_id, int $episode_id, int $show_id ): string {
        // Fetch the current sponsor data — stored in a custom options page.
        $sponsor = get_option( 'my_plugin_current_sponsor', [] );
        if ( empty( $sponsor['promo_code'] ) ) {
            return $text;
        }

        $text = str_replace( '{{PROMO_CODE}}', esc_html( $sponsor['promo_code'] ), $text );
        $text = str_replace( '{{SPONSOR_NAME}}', esc_html( $sponsor['name'] ?? '' ), $text );

        return $text;
    },
    10,
    4
);
