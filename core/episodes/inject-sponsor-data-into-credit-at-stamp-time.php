<?php
// Inject external sponsor data into a credit at stamp time

/**
 * Inject current sponsor promo code into the stamped credit.
 * Template body must include {{PROMO_CODE}} as a replacement target.
 * The filter fires BEFORE do_shortcode() runs, so any shortcodes in the
 * injected copy are still resolved and frozen into _benecaster_stamped_credit.
 */
add_filter(
    'benecaster_credit_before_stamp',
    function ( string $body, int $episode_id, string $credit_id, \WP_Post $show ): string {
        // Fetch the current sponsor data — stored in a custom options page.
        $sponsor = get_option( 'my_plugin_current_sponsor', [] );
        if ( empty( $sponsor['promo_code'] ) ) {
            return $body;
        }

        $body = str_replace( '{{PROMO_CODE}}', esc_html( $sponsor['promo_code'] ), $body );
        $body = str_replace( '{{SPONSOR_NAME}}', esc_html( $sponsor['name'] ?? '' ), $body );

        return $body;
    },
    10,
    4
);
