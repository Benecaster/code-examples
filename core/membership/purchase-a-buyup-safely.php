<?php
// Purchase a buy-up from custom code, safely

/**
 * Purchase a buy-up on behalf of the logged-in subscriber.
 *
 * @param int    $show_id      Show the subscriber holds a native subscription on.
 * @param int    $buyup_id     Buy-up belonging to that show.
 * @param int    $amount_cents The price shown to the subscriber, in minor units.
 * @param string $action_key   Stable per user action; reuse only when retrying it.
 */
function my_addon_purchase_buyup( int $show_id, int $buyup_id, int $amount_cents, string $action_key ) {
    $request = new WP_REST_Request(
        'POST',
        "/benecaster/v1/shows/{$show_id}/buyups/{$buyup_id}/subscribe"
    );
    $request->set_header( 'Idempotency-Key', $action_key );
    $request->set_body_params( [ 'confirm_amount_cents' => $amount_cents ] );

    $response = rest_do_request( $request );

    if ( $response->is_error() ) {
        $error = $response->as_error();

        // The price moved between render and click. Re-render at the new
        // amount and ask again — do not silently resubmit with the new
        // figure, because the subscriber never agreed to it.
        if ( 'amount_mismatch' === $error->get_error_code() ) {
            $data = $error->get_error_data();
            return new WP_Error(
                'price_changed',
                sprintf(
                    /* translators: %s: formatted current price */
                    __( 'The price is now %s. Please confirm the new amount.', 'my-addon' ),
                    number_format_i18n( $data['amount_cents'] / 100, 2 )
                ),
                $data
            );
        }

        return $error;
    }

    return $response->get_data(); // grant_id, stripe_subscription_item_id, buyup_id
}
