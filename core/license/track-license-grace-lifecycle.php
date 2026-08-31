<?php
// Track the payment-failed license grace lifecycle

add_action( 'benecaster_license_grace_started', function ( int $started_at, string $reason ): void {
    // Payment just failed — the 30-day window is open and subscribers are
    // unaffected for now. Warn the operator while it is still cheap to fix.
    $body = sprintf(
        /* translators: %s: the /validate reason string. */
        __( 'Your Benecaster subscription failed a payment (%s). Your subscribers are unaffected for the next 30 days. If billing is not updated by then, their private feeds stop serving entirely.', 'my-addon' ),
        $reason
    );

    wp_mail( get_option( 'admin_email' ), __( 'Benecaster: payment failed', 'my-addon' ), $body );
}, 10, 2 );

add_action( 'benecaster_license_payment_grace_hard_cutoff', function ( int $cutoff_at, int $token_count ): void {
    // Day 30. $token_count tokens were just revoked and those feeds now
    // return 403 — subscribers are NOT on the public feed. Fires once per
    // grace cycle, so no de-duplication guard is needed.
    my_addon_alert( 'license_hard_cutoff', [
        'cutoff_at'     => $cutoff_at,
        'feeds_stopped' => $token_count,
    ] );
}, 10, 2 );

add_action( 'benecaster_license_payment_grace_recovered', function ( int $restored_count, int $started_at ): void {
    // Billing fixed after a cutoff. Fires ONLY when tokens were actually
    // revoked, so reaching this callback is itself the signal — no duration
    // arithmetic. Restored subscribers keep their original feed URLs, so
    // nobody has to re-add anything.
    my_addon_alert( 'license_recovered', [
        'feeds_restored' => $restored_count,
        'outage_seconds' => time() - $started_at,
    ] );
}, 10, 2 );
