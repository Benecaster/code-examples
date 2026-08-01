<?php
// React to a badge definition being deleted

add_action( 'benecaster_badge_definition_deleted', function ( int $badge_id, int $tier_id, array $badge ): void {
    my_audit_log( sprintf( 'Tier badge "%s" (#%d) deleted from tier %d', $badge['label'], $badge_id, $tier_id ) );
}, 10, 3 );
