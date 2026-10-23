<?php
// Replace the built-in unsubscribe URL with a branded opt-out center

add_filter( 'benecaster_email_merge_tags', function ( array $tags, string $type, ?int $user_id, ?int $show_id ): array {
    // Only override for broadcast emails — leave every other type on the default link.
    if ( 'broadcast' !== $type || empty( $tags['unsubscribe_url'] ) ) {
        return $tags;
    }

    // Carry Benecaster's signed token to your page. Never build the link from the user and show IDs:
    // the token is what proves who the listener is and what they are leaving.
    parse_str( (string) wp_parse_url( $tags['unsubscribe_url'], PHP_URL_QUERY ), $query );
    if ( ! empty( $query['benecaster_unsub'] ) ) {
        $tags['unsubscribe_url'] = add_query_arg(
            'token',
            rawurlencode( $query['benecaster_unsub'] ),
            'https://example.com/email-preferences/'
        );
    }
    return $tags;
}, 20, 4 ); // priority 20 runs after Benecaster's inject_unsubscribe_url at priority 10
