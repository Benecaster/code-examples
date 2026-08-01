<?php
// Inject Podcasting 2.0 Episode Tags from an Add-on

add_filter( 'benecaster_feed_podcast_episode_tags', function ( array $tags, int $episode_id, int $show_id ): array {
    // Inject a soundbite from an external clipping service.
    $highlight = get_post_meta( $episode_id, '_my_addon_highlight', true );
    if ( is_array( $highlight ) && isset( $highlight['start'], $highlight['duration'] ) ) {
        $tags['soundbites'][] = [
            'start_time' => (float) $highlight['start'],
            'duration'   => (float) $highlight['duration'],
            'title'      => (string) ( $highlight['title'] ?? '' ),
        ];
    }

    // Append an editor credit from show meta.
    $editor_name = (string) get_post_meta( $show_id, '_my_addon_editor_name', true );
    if ( $editor_name !== '' ) {
        $tags['feed_credits'][] = [
            'role'  => 'editor',
            'name'  => $editor_name,
            'url'   => (string) get_post_meta( $show_id, '_my_addon_editor_url', true ),
        ];
    }

    return $tags;
}, 10, 3 );
