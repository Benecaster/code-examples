// Gate a tour step on what the screen actually renders

window.BenecasterExtensions = window.BenecasterExtensions || {};
window.BenecasterExtensions.tours = window.BenecasterExtensions.tours || [];

window.BenecasterExtensions.tours.push( {
    id:    'my-addon',
    label: 'My Add-on',
    steps: [
        {
            id:      'my-addon-intro',
            target:  '[data-tour="addon-card-benecaster-addon-my-addon"]',
            screen:  'addons',
            title:   'Where your add-on lives',
            content: 'Switch it on per show here.',
        },
        {
            id:      'my-addon-usage',
            target:  '[data-tour="my-addon-usage"]',
            screen:  'addons',
            title:   'Your usage this month',
            content: 'Only shown once there is something to chart.',
            // Only the server knows whether this show has usage to chart.
            condition: async ( showId ) => {
                if ( null === showId || showId <= 0 ) {
                    return false; // No show selected: nothing to ask about.
                }
                try {
                    const res = await fetch(
                        `${ window.benecasterAdmin.apiUrl }shows/${ showId }/my-addon/usage`,
                        { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } }
                    );
                    if ( ! res.ok ) {
                        return false;
                    }
                    const data = await res.json();
                    return Array.isArray( data.rows ) && data.rows.length > 0;
                } catch {
                    return false; // When in doubt, drop the step.
                }
            },
        },
    ],
} );
