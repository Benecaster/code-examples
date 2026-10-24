<?php
// Implement a custom bridge that returns multiple active tiers per user

class MyCustomBridge implements \Benecaster\Bridge\BridgeInterface {
    public function get_all_user_tiers( int $user_id, int $show_id ): array {
        $slugs = [];
        foreach ( my_plugin_get_user_memberships( $user_id ) as $membership ) {
            $tier = $this->tier_map->find_by_show_and_external( $show_id, 'my-plugin', (string) $membership->level_id );
            if ( $tier ) {
                $slugs[] = $tier->internal_tier_slug;
            }
        }
        return $slugs;
    }
    // ... other BridgeInterface methods
}
