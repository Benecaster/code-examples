// Point your add-on's tour at your own Show Settings tab

window.BenecasterExtensions = window.BenecasterExtensions || {};
window.BenecasterExtensions.tours = window.BenecasterExtensions.tours || [];

const ADDON = 'benecaster-addon-my-addon';

// A show where this add-on is granted and not switched off.
const show = ( window.benecasterAdmin?.addonShows || [] ).find(
    ( row ) => row.granted.includes( ADDON ) && ! row.disabled.includes( ADDON )
);

if ( show ) {
    window.BenecasterExtensions.tours.push( {
        id:    'my-addon',
        label: 'My Add-on',
        steps: [
            {
                id:      'my-addon-entry',
                target:  '[data-tour="my-addon-nav"]',
                screen:  `/shows/${ show.id }/settings/my-addon`,
                title:   'Your add-on lives here',
                content: 'Everything this add-on does for a show is on this tab.',
            },
        ],
    } );
}
