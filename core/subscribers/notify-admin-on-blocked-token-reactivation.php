<?php
// Notify the Ops Channel When a Token Reactivation Is Blocked

add_action(
    'benecaster_token_reactivation_blocked',
    function ( int $token_id, int $user_id, int $show_id, string $tier_slug, string $reason ): void {
        $user = get_userdata( $user_id );
        $show = get_the_title( $show_id );
        if ( ! $user || '' === $show ) {
            return;
        }

        // Non-blocking Slack POST — do not let a slow webhook stall the
        // bridge activation path. `blocking => false` returns before the
        // response arrives; failures are silent by design.
        wp_remote_post( 'https://hooks.slack.com/services/T000/B000/XXX', [
            'blocking' => false,
            'timeout'  => 2,
            'body'     => wp_json_encode( [
                'text' => sprintf(
                    ':warning: %s tried to reactivate on *%s* (%s) but their token is admin-revoked (reason: `%s`). Review in %s',
                    $user->user_email,
                    $show,
                    $tier_slug,
                    $reason,
                    admin_url( 'admin.php?page=benecaster-subscribers&show_id=' . $show_id )
                ),
            ] ),
        ] );
    },
    10,
    5
);
