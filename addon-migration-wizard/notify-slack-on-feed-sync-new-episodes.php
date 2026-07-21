// Notify production team on Slack when new episodes found during feed sync
add_action(
    'benecaster_feed_sync_after',
    function ( int $show_id, array $created_ids, array $skipped ): void {
        if ( empty( $created_ids ) ) {
            return;
        }
        $lines = [];
        foreach ( $created_ids as $episode_id ) {
            $lines[] = '- ' . get_the_title( (int) $episode_id );
        }
        $payload = [
            'text' => sprintf(
                "*%s* — %d new draft(s) from feed sync:\n%s",
                get_the_title( $show_id ),
                count( $created_ids ),
                implode( "\n", $lines )
            ),
        ];
        wp_remote_post( 'https://hooks.slack.com/services/T000/B000/XXXX', [
            'timeout'  => 5,
            'blocking' => false,
            'headers'  => [ 'Content-Type' => 'application/json' ],
            'body'     => wp_json_encode( $payload ),
        ] );
    },
    10,
    3
);
