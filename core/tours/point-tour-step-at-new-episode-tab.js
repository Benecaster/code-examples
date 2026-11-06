// Point a tour step at a tab of a new episode

window.BenecasterExtensions.tours.push( {
    id: 'my-addon', label: 'My Add-on Tour',
    steps: [ {
        id:      'my-addon-guests',
        target:  '[data-tour="episode-guest-selector"]',
        screen:  'episode-editor:guests',   // one of Benecaster's tabs, or your own tab's `id`
        title:   'Link guests to episodes',
        content: 'Explain the selector here.',
        // The target only exists where Guest Manager is on for the current show.
        condition: ( showId ) => window.BenecasterExtensions.addonIsActive( 'benecaster-addon-guest-manager', showId ),
    } ],
} );
