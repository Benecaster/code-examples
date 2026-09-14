<?php
// Break a failed-token spike down by source

add_action(
    'benecaster_invalid_token_recorded',
    function ( int $show_id, int $current_count, array $context ): void {
        $source = $context['ip_hash'] ?? 'unknown';
        $key    = 'my_bad_token_' . $show_id . '_' . substr( (string) $source, 0, 16 );

        // Your own short-lived per-source tally. One transient per
        // source: on a site without a persistent object cache these are
        // wp_options rows, so keep the TTL short.
        $hits = (int) get_transient( $key ) + 1;
        set_transient( $key, $hits, HOUR_IN_SECONDS );

        // One source responsible for most of the show's failures in the
        // window looks like a scraper or a guessing run, not a typo.
        if ( $hits >= 20 && $hits * 2 >= $current_count ) {
            my_ops_alert( sprintf(
                'Show #%d: %d failed token attempts in %d min, %d from one source (%s)',
                $show_id,
                $current_count,
                $context['window_minutes'],
                $hits,
                $context['country_code'] ?? '??'
            ) );
        }
    },
    10,
    3
);
