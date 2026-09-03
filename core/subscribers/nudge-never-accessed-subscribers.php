<?php
// Nudge Subscribers Who Never Set Up Their Podcast App

add_action(
    'benecaster_subscriber_never_accessed',
    function ( int $user_id, int $show_id, string $tier_slug, int $days_since_created ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }

        $show_name = get_the_title( $show_id );
        $subject   = sprintf( 'Need help setting up %s?', $show_name );
        $body      = sprintf(
            "Hi %s,\n\nWe noticed your %s feed hasn't been added to a podcast app yet. "
            . "Grab your private feed URL from %s and paste it into Apple Podcasts, Overcast, "
            . "or Pocket Casts — full instructions here: %s\n\nWelcome aboard.",
            $user->display_name,
            $show_name,
            home_url( '/podcast-account/' ),
            home_url( '/docs/podcast-app-setup/' )
        );

        benecaster_mail( $show_id, $user->user_email, $subject, $body );
    },
    10,
    4
);
