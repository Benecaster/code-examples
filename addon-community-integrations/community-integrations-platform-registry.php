<?php
// Register a community platform, and know when the add-on calls it

// Register only where the add-on (and so the interface) is loaded.
add_action( 'plugins_loaded', function (): void {
    if ( interface_exists( \Benecaster\Community\CommunityPlatformInterface::class ) ) {
        require __DIR__ . '/class-my-platform.php'; // class My_Platform implements the interface
        add_filter( 'benecaster_community_platforms', fn( array $p ): array => $p + [ 'my-platform' => new My_Platform() ] );
    }
} );

// Inside My_Platform: a failure message the podcaster can act on, no secrets.
public function addMember( int $user_id, int $show_id, string $tier_slug ): bool {
    $response = my_platform_api_add( $show_id, $user_id, $tier_slug );
    if ( 403 === $response['status'] ) {
        throw new \RuntimeException( 'My Platform refused: the API key for this show cannot add members.' );
    }
    return 200 === $response['status'];
}
