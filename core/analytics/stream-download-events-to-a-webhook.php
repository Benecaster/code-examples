<?php
// Stream every authenticated 302-proxy download event to an external webhook

add_action(
    'benecaster_download_logged',
    function ( int $episode_id, int $user_id, array $log_entry ): void {
        wp_remote_post(
            'https://example.com/webhooks/benecaster-downloads',
            [
                'timeout'  => 5,
                'blocking' => false,
                'body'     => wp_json_encode( [
                    'episode_id'   => $episode_id,
                    'user_id'      => $user_id,
                    'tier_slug'    => $log_entry['tier_slug'] ?? null,
                    'requested_at' => gmdate( 'c' ),
                ] ),
            ]
        );
    },
    10,
    3
);
