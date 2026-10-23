<?php
// Add a Custom Section at the End of a Subscription Card on the Subscriber Account Page

add_action(
    'benecaster_after_account_email_preferences',
    function ( int $show_id, int $user_id ): void {
        $history_url = add_query_arg(
            [ 'show' => $show_id, 'subscriber' => $user_id ],
            home_url( '/episode-history/' )
        );
        printf(
            '<div class="my-account-history"><h3>%s</h3><a href="%s">%s</a></div>',
            esc_html__( 'Your listening history', 'my-plugin' ),
            esc_url( $history_url ),
            esc_html__( 'View episodes you\'ve accessed →', 'my-plugin' )
        );
    },
    10,
    2
);
