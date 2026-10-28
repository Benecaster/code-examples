// Add your add-on's panel to the Analytics screen

const { React, i18n } = window.BenecasterExtensions; // Benecaster's shared runtime: never bundle your own React
const ext = ( window.BenecasterExtensions ??= {} );
( ext.analyticsPanels ??= [] ).push( {
    id: 'outlinks-clicks',                       // unique: prefix with your add-on
    title: i18n.__( 'Link clicks', 'benecaster-outlinks' ),
    order: 50,                                   // optional, default 100; lower first
    render: ( { showId, scope, dateFrom, dateTo, tierSlug } ) =>
        React.createElement( LinkClicks, { showId, scope, dateFrom, dateTo } ),
} );
