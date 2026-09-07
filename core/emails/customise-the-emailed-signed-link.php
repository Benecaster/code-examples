<?php
// Customise the emailed signed link — lifetime, landing page, and what happens on click

/**
 * Shorten the life of emailed account links from one week to 48 hours.
 *
 * ⚠ Shorter is safer, but not free: the link lives in a mailbox, and a
 * follower who submits the form on a Friday evening and opens their mail on
 * Monday must still be able to click it. Do not go below a day without a
 * reason — an expired link costs you the signup, not just the click.
 *
 * @param int    $ttl     Seconds. Default WEEK_IN_SECONDS.
 * @param string $purpose One of SignedLink::PURPOSE_*.
 */
add_filter( 'benecaster_signed_link_ttl', function ( int $ttl, string $purpose ): int {
    return \Benecaster\Support\SignedLink::PURPOSE_ACCOUNT_ACCESS === $purpose
        ? 2 * DAY_IN_SECONDS
        : $ttl;
}, 10, 2 );

/**
 * Land followers on a custom members page instead of the account page.
 *
 * ⚠ Return an absolute URL on this site. The link is consumed by
 * SignedLinkEndpoint on `init` wherever it lands, so the destination only
 * decides what the follower SEES — but wp_safe_redirect() will refuse an
 * off-site host and drop them on the home page instead.
 */
add_filter( 'benecaster_signed_link_base_url', function ( string $url, string $purpose, int $show_id ): string {
    $page = get_page_by_path( 'members' );

    return $page instanceof WP_Post ? get_permalink( $page ) : $url;
}, 10, 3 );

/**
 * Do something once, the first and only time a link is clicked.
 *
 * ⚠ Fires AFTER the token is spent, so a replay never reaches this — which
 * is exactly why it is safe to do something non-idempotent here. Firing it
 * before consumption would let anyone with a copy of the URL run it twice.
 */
add_action( 'benecaster_signed_link_consumed', function ( int $user_id, string $purpose, int $show_id ): void {
    if ( \Benecaster\Support\SignedLink::PURPOSE_ACCOUNT_ACCESS !== $purpose ) {
        return;
    }

    update_user_meta( $user_id, '_my_addon_confirmed_email_at', time() );
}, 10, 3 );

/**
 * Show a friendly notice when someone arrives from a dead link.
 *
 * ⚠ Say only that the link no longer works. Do NOT try to explain WHY —
 * core deliberately gives every refusal the same destination, because
 * distinguishing "expired" from "already used" from "not a real link"
 * tells someone holding a stolen or guessed token which part of it to work
 * on. Reading this flag and printing four different messages would rebuild
 * exactly the oracle the single destination removes.
 */
add_action( 'benecaster_before_account', function (): void {
    if ( empty( $_GET['benecaster_link_expired'] ) ) {
        return;
    }

    printf(
        '<p class="notice">%s</p>',
        esc_html__( 'That link has expired or has already been used. Sign in, or use the follow form again to get a new one.', 'my-theme' )
    );
} );

/**
 * Nudge passwordless arrivals towards setting a password, once.
 *
 * ⚠ Fires IN ADDITION to wp_login, not instead of it. A listener hooked to
 * both will run twice for one arrival — pick one.
 */
add_action( 'benecaster_signed_link_logged_in', function ( int $user_id, string $purpose ): void {
    if ( get_user_meta( $user_id, '_my_addon_password_nudged', true ) ) {
        return;
    }

    update_user_meta( $user_id, '_my_addon_password_nudged', 1 );
    set_transient( 'my_addon_nudge_' . $user_id, 1, HOUR_IN_SECONDS );
}, 10, 2 );
