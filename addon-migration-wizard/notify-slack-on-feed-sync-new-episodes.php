<?php
// Notify production team on Slack when new episodes found during feed sync

add_action(
    'benecaster_feed_sync_completed',
    function ( array $result ): void {
        if ( 'success' !== $result['status'] || empty( $result['draft_ids'] ) ) {
            return;
        }

        $lines = array_map(
            static fn ( $id ): string => '- ' . get_the_title( (int) $id ),
            $result['draft_ids']
        );

        wp_remote_post( 'https://hooks.slack.com/services/T000/B000/XXXX', [
            'timeout'  => 5,
            'blocking' => false,
            'headers'  => [ 'Content-Type' => 'application/json' ],
            'body'     => wp_json_encode( [
                'text' => sprintf(
                    "*%s*: %d new draft(s) from Feed Sync (%s):\n%s",
                    get_the_title( (int) $result['show_id'] ),
                    count( $result['draft_ids'] ),
                    $result['triggered_by'],
                    implode( "\n", $lines )
                ),
            ] ),
        ] );
    }
);
