<?php
// Add an add-on tab to one show's settings

// my-addon/resources/js/admin.jsx — enqueued with 'benecaster-admin' as a dependency
// and built with Benecaster's React runtime mapped as externals.
import { useQuery } from '@tanstack/react-query';

const MySettingsTab = ( { showId } ) => {
    const { data } = useQuery( {
        queryKey: [ 'my-addon-settings', showId ],
        queryFn:  () => window.wp.apiFetch( { path: `/my-addon/v1/shows/${ showId }/settings` } ),
    } );
    return <div className="bc-space-y-4">{ /* … */ }</div>;
};

wp.domReady( () => {
    window.BenecasterExtensions?.registerFill( 'BenecasterShowSettingsPage_my-addon', MySettingsTab );
} );
