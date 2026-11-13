<?php
// Integrate a community platform not in the Benecaster set

class MyPlatform implements \Benecaster\Community\CommunityPlatformInterface {

    public function getSlug(): string { return 'my-platform'; }

    public function isConfigured( int $show_id ): bool {
        return (bool) get_post_meta( $show_id, 'my_platform_space_id', true );
    }

    public function addMember( int $user_id, int $show_id, string $tier_slug ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_add_member( $show_id, $email, $tier_slug );
    }

    public function removeMember( int $user_id, int $show_id ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_remove_member( $show_id, $email );
    }

    public function updateMemberTier( int $user_id, int $show_id, string $old_tier, string $new_tier ): bool {
        $email = get_userdata( $user_id )->user_email;
        return my_platform_api_update_tier( $show_id, $email, $new_tier );
    }

    public function onEpisodePublished( int $episode_id, int $show_id ): void {
        // get_the_title() returns HTML (Dave&#8217;s Q&#038;A); this is plain text.
        my_platform_api_post_announcement( $show_id, html_entity_decode( get_the_title( $episode_id ), ENT_QUOTES, 'UTF-8' ) );
    }
}

// Registration. Keyed by platform slug; the value is your instance.
add_filter( 'benecaster_community_platforms', function ( array $platforms ): array {
    $platforms['my-platform'] = new MyPlatform();

    return $platforms;
} );
