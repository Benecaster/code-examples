// Register a guided product tour from an add-on JS bundle

window.BenecasterExtensions = window.BenecasterExtensions || {};
window.BenecasterExtensions.tours = window.BenecasterExtensions.tours || [];

window.BenecasterExtensions.tours.push( {
    id:    'email-editor',
    label: 'Email Editor Tour',
    // `addons` holds full entitlement slugs; the short slug 'email-editor' matches nothing.
    condition: () => window.benecasterAdmin.addons.includes( 'benecaster-addon-email-editor' ),
    steps: [
        {
            id:       'pick-template',
            target:   '[data-tour="email-editor-template-picker"]',
            screen:   'settings',
            title:    'Pick a template',
            content:  'Start from a built-in template or duplicate one of your own.',
            position: 'bottom',
        },
        // …
    ],
} );
