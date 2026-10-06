<?php
// Populate a block or widget picker without needing an administrator

// Hand the fixed picker lists to your block's editor script, so it needs no
// request for them. Shows, tiers, seasons and episodes come from the Editor
// Pickers REST routes at edit time.
add_action( 'enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'my-benecaster-blocks',
        plugins_url( 'build/editor.js', __FILE__ ),
        [ 'wp-api-fetch', 'wp-blocks', 'wp-components', 'wp-element' ],
        '1.0.0',
        true
    );

    wp_localize_script( 'my-benecaster-blocks', 'myBenecasterPickers', [
        'socialPlatforms'  => benecaster_get_social_platforms(),  // [benecaster_social_links]
        'podcastPlatforms' => benecaster_get_podcast_platforms(), // [benecaster_platform_links], ends with `rss`
        'autoPlatforms'    => benecaster_get_automatic_podcast_platforms(), // no URL to enter: [ 'rss' ]
        'sharePlatforms'   => benecaster_get_share_platforms(),   // [benecaster_episode_share], also its default
        'shareMergeTags'   => benecaster_get_share_merge_tags(),  // tags its `text` attribute resolves
    ] );
} );
