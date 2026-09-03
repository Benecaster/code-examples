<?php
// Integrate a community platform not in the Benecaster set

class MyPlatform implements \Benecaster\Community\CommunityPlatformInterface {

    public function getSlug(): string { return 'my-platform'; }

    public function isConfigured(): bool {
        return (bool) get_option( 'my_platform_api_key' );
    }

    public function addMember( int $user_id, string $tier_slug ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_add_member( $email, $tier_slug );
    }

    public function removeMember( int $user_id ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_remove_member( $email );
    }

    public function updateMemberTier( int $user_id, string $old_tier, string $new_tier ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_update_tier( $email, $new_tier );
    }

    public function onEpisodePublished( int $episode_id, int $show_id ): void {
        if ( ! $this->isConfigured() ) { return; }
        my_platform_api_post_announcement( get_the_title( $episode_id ) );
    }
}

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    $container->make( \Benecaster\Community\CommunityPlatformRegistry::class )
              ->register( new MyPlatform() );
} );
