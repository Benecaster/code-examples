<?php
// Add custom merge tags to all emails

add_filter(
    'benecaster_email_merge_tags',
    function ( array $tags, string $type, int $user_id, int $show_id ): array {
        $tags['show_manager_name']  = (string) get_post_meta( $show_id, '_my_addon_manager_name', true );
        $tags['show_manager_email'] = (string) get_post_meta( $show_id, '_my_addon_manager_email', true );
        $tags['episode_count']      = (string) wp_count_posts( 'benecaster_episode' )->publish;
        return $tags;
    },
    10,
    4
);
