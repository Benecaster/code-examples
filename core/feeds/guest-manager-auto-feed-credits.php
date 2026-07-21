// Auto-populate Feed Credits from Guest Manager
add_filter(
    'benecaster_podcast2_episode_auto_feed_credits',
    function ( array $credits, int $episode_id, int $show_id ): array {
        $guest_ids = (array) get_post_meta( $episode_id, '_my_addon_episode_guests', true );
        foreach ( $guest_ids as $guest_id ) {
            $post = get_post( (int) $guest_id );
            if ( ! $post || 'my_addon_guest' !== $post->post_type ) {
                continue;
            }
            $credits[] = [
                'role'       => 'guest',
                'name'       => $post->post_title,
                'url'        => (string) get_post_meta( $post->ID, 'website', true ),
                'image'      => (string) get_post_meta( $post->ID, 'photo_url', true ),
                'source'     => 'Guest Manager',
                'source_url' => admin_url( 'post.php?post=' . $post->ID . '&action=edit' ),
            ];
        }
        return $credits;
    },
    10,
    3
);
