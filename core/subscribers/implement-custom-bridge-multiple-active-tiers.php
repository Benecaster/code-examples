<?php
// Implement a custom bridge that returns multiple active tiers per user

class MyCustomBridge implements \Benecaster\Bridge\BridgeInterface {
    public function get_all_user_tiers( int $user_id, int $show_id ): array {
        $slugs = [];
        foreach ( my_plugin_get_user_memberships( $user_id ) as $membership ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $membership->level_id );
            if ( $tier && (int) $tier->show_id === $show_id ) {
                $slugs[] = $tier->internal_tier_slug;
            }
        }
        return $slugs;
    }
    // ... other BridgeInterface methods
}
