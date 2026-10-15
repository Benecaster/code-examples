<?php
// Nudge Subscribers Who Never Set Up Their Podcast App

add_action(
    'benecaster_subscriber_never_accessed',
    function ( int $user_id, int $show_id, string $tier_slug, int $days_since_created ): void {
        $user = get_userdata( $user_id );
        if ( ! $user ) {
            return;
        }

        // get_the_title() returns HTML (Dave&#8217;s Q&#038;A); this is plain text.
        $show_name = html_entity_decode( get_the_title( $show_id ), ENT_QUOTES, 'UTF-8' );
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
