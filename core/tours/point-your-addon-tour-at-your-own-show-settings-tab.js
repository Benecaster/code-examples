// Point your add-on's tour at your own Show Settings tab

window.BenecasterExtensions = window.BenecasterExtensions || {};
window.BenecasterExtensions.tours = window.BenecasterExtensions.tours || [];

window.BenecasterExtensions.tours.push( {
    id:    'my-addon',
    label: 'My Add-on',
    steps: [
        {
            id:      'my-addon-entry',
            target:  '[data-tour="my-addon-nav"]',
            // Your page's `id`. The current show is filled in when the tour starts,
            // and the step is left out where the add-on is off for that show.
            screen:  'show-settings:my-addon',
            title:   'Your add-on lives here',
            content: 'Everything this add-on does for a show is on this tab.',
        },
        {
            id:      'my-addon-reference-control',
            target:  '[data-tour="my-reference-control"]',
            screen:  'episode-references',   // the same show as the step above
            title:   'Then use it on an episode',
            content: 'Explain the control here.',
        },
    ],
} );
