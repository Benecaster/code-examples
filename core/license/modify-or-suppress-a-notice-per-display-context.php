<?php
// Modify or suppress an admin notice per display context immediately before it reaches the React app

add_filter(
    'benecaster_before_notice_display',
    function ( array $notice, string $context ): ?array {
        // Hide marketing notices from the persistent bar — keep them in the bell panel only.
        if ( 'marketing' === $notice['type'] && 'bar' === $context ) {
            return null;
        }

        // Rewrite the action label of a specific notice when shown in the bar
        // so the CTA fits on one line, while keeping the original copy in the bell.
        if ( 'feed_sync_failures' === $notice['notice_id'] && 'bar' === $context ) {
            $notice['action_label'] = __( 'Fix now', 'my-addon' );
        }

        return $notice;
    },
    10,
    2
);
