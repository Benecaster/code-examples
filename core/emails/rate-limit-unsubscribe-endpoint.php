// Rate-limit unsubscribe endpoint to prevent abuse
add_filter(
    'benecaster_email_unsubscribe_allowed',
    function ( bool $allowed, ?int $user_id, int $show_id, string $type, string $token ): bool {
        if ( ! $allowed ) {
            return false; // already blocked upstream
        }

        // Allow at most 5 unsubscribe attempts per hour per token.
        // Uses a WordPress transient as a lightweight counter.
        if ( '' !== $token ) {
            $key     = 'bc_unsub_rate_' . substr( $token, 0, 16 );
            $count   = (int) get_transient( $key );
            if ( $count >= 5 ) {
                return false; // rate-limited — do not record opt-out
            }
            set_transient( $key, $count + 1, HOUR_IN_SECONDS );
        }

        return true;
    },
    10, 5
);
