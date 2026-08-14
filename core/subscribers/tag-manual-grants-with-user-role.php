<?php
// Tag Manual Grants with User Role

// On grant: add the comped subscriber to a "beta-testers" WP role AND
// push them to a CRM segment. Runs on the same request as the admin's
// POST /shows/{id}/subscribers/manual, so it's safe to make outbound
// HTTP calls here — the admin sees the modal spin briefly.
add_action( 'benecaster_manual_subscriber_created', function ( int $user_id, int $show_id, string $tier_slug, ?string $expiry_at ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    // Add a WordPress role for gate control on other themes / plugins.
    $user->add_role( 'beta_tester' );

    // Push to a CRM segment via HTTP. $expiry_at is a UTC MySQL
    // datetime string ('YYYY-MM-DD HH:MM:SS') or null for no-expiry.
    wp_remote_post( 'https://crm.example.com/api/tag', [
        'body' => wp_json_encode( [
            'email'      => $user->user_email,
            'tag'        => 'benecaster-comp',
            'show_id'    => $show_id,
            'tier'       => $tier_slug,
            'expires_at' => $expiry_at,
        ] ),
    ] );
}, 10, 4 );

// On auto-expiry: remove the same state. Runs from cron, so an outbound
// HTTP failure will not block anything on the admin side.
add_action( 'benecaster_manual_grant_expired', function ( int $user_id, int $show_id ): void {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    $user->remove_role( 'beta_tester' );

    wp_remote_post( 'https://crm.example.com/api/untag', [
        'body' => wp_json_encode( [
            'email'   => $user->user_email,
            'tag'     => 'benecaster-comp',
            'show_id' => $show_id,
        ] ),
    ] );
}, 10, 2 );
