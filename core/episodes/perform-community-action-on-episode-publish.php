<?php
// Perform a community action on episode publish

// Circle's built-in onEpisodePublished() — canonical example.
public function onEpisodePublished( int $episode_id, int $show_id ): void {
    if ( ! $this->isConfigured() ) { return; }

    $mode     = get_post_meta( $episode_id, '_benecaster_circle_discussion_mode', true ) ?: 'default';
    $globally = (bool) get_option( 'benecaster_circle_auto_discussion' );

    if ( $mode === 'skip' || ( $mode === 'default' && ! $globally ) ) { return; }

    $space_id = get_post_meta( $episode_id, '_benecaster_circle_discussion_space', true )
                ?: get_option( 'benecaster_circle_episode_discussion_space' );
    if ( ! $space_id ) { return; }

    $post_url = $this->client->createPost(
        $space_id,
        get_the_title( $episode_id ),
        get_post_meta( $episode_id, '_benecaster_description_rss', true )
    );

    if ( $post_url ) {
        update_post_meta( $episode_id, '_benecaster_circle_discussion_url', $post_url );
    }
}
