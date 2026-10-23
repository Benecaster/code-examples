<?php
// Let Sync existing members work with a custom bridge

class My_Bridge implements \Benecaster\Bridge\BridgeInterface, \Benecaster\Bridge\BridgeMemberListing {
    // … the BridgeInterface methods …

    public function list_active_member_ids( string $external_level_id, int $offset, int $limit ): array {
        $rows = my_plugin_active_members( (int) $external_level_id, $offset, $limit ); // oldest first
        // One entry per row, 0 where there is no WordPress user, so a short page means "done".
        return array_map( static fn( $row ): int => (int) ( $row->wp_user_id ?? 0 ), $rows );
    }

    public function get_member_start_date( int $user_id, array $external_level_ids ): ?string {
        $local = my_plugin_earliest_start( $user_id, array_map( 'intval', $external_level_ids ) );
        // Convert from your plugin's clock to UTC here. Null when there is no real date.
        return $local ? get_gmt_from_date( $local ) : null;
    }
}
