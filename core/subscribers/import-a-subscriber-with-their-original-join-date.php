<?php
// Import a subscriber with their original join date

use Benecaster\Token\BackdateGuard;
use Benecaster\Token\TokenManager;

/**
 * @param array<int, array{user_id: int, join_date: string}> $rows Parsed CSV.
 * @return array{imported: int, rejected: array<int, array{user_id: int, join_date: string, reason: string}>}
 */
function my_addon_import_with_tenure( TokenManager $manager, array $rows, int $show_id, string $tier_slug ): array {
    $guard    = new BackdateGuard();
    $good     = [];
    $rejected = [];

    // Pass one: judge every row before writing any of them. reason() returns
    // null when the date is fine, otherwise a stable code — 'unparseable',
    // 'future' or 'before_floor' — that you can group and translate yourself.
    foreach ( $rows as $row ) {
        $reason = $guard->reason( $row['join_date'] );

        if ( null === $reason ) {
            $good[] = $row;
            continue;
        }

        $rejected[] = $row + [ 'reason' => $reason ];
    }

    // Show the operator the rejects BEFORE importing. A half-finished
    // migration is much harder to reason about than one that has not started.
    if ( $rejected !== [] ) {
        my_addon_report_bad_rows( $rejected );
    }

    $imported = 0;
    foreach ( $good as $row ) {
        $token = $manager->generate(
            $row['user_id'],
            $show_id,
            $tier_slug,
            'subscriber',
            $row['join_date']   // already validated above
        );

        my_addon_email_feed_url( $row['user_id'], $token );
        $imported++;
    }

    return [ 'imported' => $imported, 'rejected' => $rejected ];
}
