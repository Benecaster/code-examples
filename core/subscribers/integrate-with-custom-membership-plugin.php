<?php
// Integrate with a membership plugin not in the built-in bridge set

class MyPlugin_Bridge implements \Benecaster\Bridge\BridgeInterface {

    public function __construct(
        private readonly \Benecaster\Show\TierMapRepository $tier_map
    ) {}

    public function get_plugin_slug(): string {
        return 'my-plugin';
    }

    public function get_user_tier( int $user_id, int $show_id ): ?string {
        foreach ( my_plugin_get_active_levels( $user_id ) as $level_id ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier && (int) $tier->show_id === $show_id ) {
                return $tier->internal_tier_slug;
            }
        }
        return null;
    }

    // Required, and NOT the same as get_user_tier(): a subscriber with two
    // memberships mapped to one show gets the union of both tiers' episodes.
    public function get_all_user_tiers( int $user_id, int $show_id ): array {
        $slugs = [];
        foreach ( my_plugin_get_active_levels( $user_id ) as $level_id ) {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier && (int) $tier->show_id === $show_id ) {
                $slugs[] = $tier->internal_tier_slug;
            }
        }
        return array_values( array_unique( $slugs ) );
    }

    public function is_user_active( int $user_id, int $show_id ): bool {
        return null !== $this->get_user_tier( $user_id, $show_id );
    }

    // Rows are keyed by YOUR plugin's external tier id - that is what the
    // mapping UI stores. 'price' may be null when it cannot be resolved.
    public function get_all_tiers( int $show_id ): array {
        return array_map( fn( $level ) => [
            'id'    => $level->id,
            'name'  => $level->name,
            'price' => $level->price ?? null,
        ], my_plugin_get_all_levels() );
    }

    public function on_subscription_activated( callable $callback ): void {
        add_action( 'my_plugin_member_activated', function ( $user_id, $level_id ) use ( $callback ): void {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier ) {
                // user_id, show_id, tier_slug, reason - four arguments.
                $callback( (int) $user_id, (int) $tier->show_id, $tier->internal_tier_slug, 'new' );
            }
        }, 10, 2 );
    }

    public function on_subscription_cancelled( callable $callback ): void {
        add_action( 'my_plugin_member_cancelled', function ( $user_id, $level_id ) use ( $callback ): void {
            $tier = $this->tier_map->find_by_external( 'my-plugin', (string) $level_id );
            if ( $tier ) {
                $callback( (int) $user_id, (int) $tier->show_id );
            }
        }, 10, 2 );
    }

    // No-ops are the correct implementation when your plugin has no
    // matching event - but they must exist to satisfy the interface.
    public function on_subscription_changed( callable $callback ): void {}
    public function on_subscription_renewed( callable $callback ): void {}
    public function on_payment_failed( callable $callback ): void {}
    public function on_tier_saved( callable $callback ): void {}
}

// ⚠ This is where it stops. BridgeManager has no registration point, so
// there is currently nothing to hand the class to. Left here deliberately
// to show the shape the registration call will take when it ships.
add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    // $container->make( \Benecaster\Bridge\BridgeManager::class )
    //           ->set_active_bridge( YOUR_SHOW_ID, 'my-plugin' );
} );
