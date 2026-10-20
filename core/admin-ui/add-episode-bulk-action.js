// Act on the episodes a podcaster ticks — and badge each row with your status

wp.domReady( () => {
    const { registerEpisodeBulkAction, registerFill, addonIsActive, React } = window.BenecasterExtensions;

    registerEpisodeBulkAction( {
        id:    'my-addon-process',
        label: wp.i18n.__( 'Process selected', 'my-addon' ),
        addon: 'my-addon',             // offered only where it is licensed and switched on
        route: 'my-addon/v1/process',  // Benecaster POSTs { episode_ids, show_id } with the nonce
    } );

    registerFill( 'BenecasterEpisodeListRow', ( { episodeId, showId } ) => {
        if ( ! addonIsActive( 'my-addon', showId ) ) return null; // Benecaster cannot gate a fill for you
        const status = window.myAddonStatuses?.[ episodeId ];     // fetched once for the page, not per row
        return status ? React.createElement( 'span', { className: 'my-addon-badge' }, status ) : null;
    } );
} );
