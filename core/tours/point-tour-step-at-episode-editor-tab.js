// Point a tour step at your tab in the episode editor, on a real episode

window.BenecasterExtensions.tours.push( {
    id: 'my-addon', label: 'My Add-on Tour',
    steps: [ {
        id:      'my-addon-tab',
        target:  '[data-tour="my-addon-tab-panel"]',
        screen:  'episode-tab:my-addon',   // your tab's `id`
        title:   'Your episodes, transcribed',
        content: 'Explain the tab here.',
    } ],
} );

// Optional: choose WHICH episode. Without this, Benecaster opens the current show's most recent episode.
window.BenecasterExtensions.registerEpisodeTabLookup( 'my-addon', async ( showId ) => {
    const res = await fetch( `/wp-json/my-addon/v1/shows/${ showId }/tour-episode`, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } );
    return res.ok ? ( await res.json() ).episode_id ?? null : null; // null drops the step
} );
