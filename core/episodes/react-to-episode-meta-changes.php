<?php
// React to episode meta changes (audio URL, type, description)

add_action( 'benecaster_episode_meta_updated', function ( int $episode_id, int $show_id, array $changed_meta ): void {
    if ( ! isset( $changed_meta['_benecaster_audio_url'] ) ) {
        return;
    }
    $new_url = $changed_meta['_benecaster_audio_url']['new'];
    my_addon_sync_audio_url( $episode_id, $new_url );
}, 10, 3 );
