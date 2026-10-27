<?php
// Change the wording of the Link Health warning under Notifications

add_filter( 'benecaster_outlinks_health_notice_message', function ( string $message, int $count, array $broken_items ): string {
    $tracked = count( array_filter( $broken_items, fn( array $item ): bool => 'redirect' === $item['kind'] ) );
    return $tracked > 0 ? sprintf( '%d broken, %d of them tracked links. Fix the tracked ones first.', $count, $tracked ) : $message;
}, 10, 3 );
