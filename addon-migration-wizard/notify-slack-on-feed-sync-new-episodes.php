<?php
// Notify production team on Slack when new episodes found during feed sync

add_action(
    'benecaster_feed_sync_completed',
    function ( array $result ): void {
        if ( 'success' !== $result['status'] || empty( $result['draft_ids'] ) ) {
            return;
        }

        $lines = array_map(
            // get_the_title() returns HTML (Dave&#8217;s Q&#038;A); this is plain text.
            static fn ( $id ): string => '- ' . html_entity_decode( get_the_title( (int) $id ), ENT_QUOTES, 'UTF-8' ),
            $result['draft_ids']
        );

        wp_remote_post( 'https://hooks.slack.com/services/T000/B000/XXXX', [
            'timeout'  => 5,
            'blocking' => false,
            'headers'  => [ 'Content-Type' => 'application/json' ],
            'body'     => wp_json_encode( [
                'text' => sprintf(
                    "*%s*: %d new draft(s) from Feed Sync (%s):\n%s",
                    html_entity_decode( get_the_title( (int) $result['show_id'] ), ENT_QUOTES, 'UTF-8' ),
                    count( $result['draft_ids'] ),
                    $result['triggered_by'],
                    implode( "\n", $lines )
                ),
            ] ),
        ] );
    }
);
