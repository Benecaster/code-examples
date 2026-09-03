<?php
// Replace the built-in unsubscribe URL with a branded opt-out center

add_filter( 'benecaster_email_merge_tags', function ( array $tags, string $type, ?int $user_id, ?int $show_id ): array {
    // Only override for broadcast emails — leave transactional emails using the default.
    if ( 'broadcast' !== $type ) {
        return $tags;
    }
    if ( null !== $user_id && null !== $show_id ) {
        $tags['unsubscribe_url'] = add_query_arg( [
            'user'    => $user_id,
            'show'    => $show_id,
            'ref'     => 'benecaster',
        ], 'https://example.com/email-preferences/' );
    }
    return $tags;
}, 20, 4 ); // priority 20 runs after Benecaster's inject_unsubscribe_url at priority 10
