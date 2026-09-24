<?php
// Inject a React component into a named slot

// my-addon/resources/js/admin.jsx (compiled with Benecaster's runtime as externals)
import { useState } from 'react';
import { useQuery } from '@tanstack/react-query';
import { __ } from '@wordpress/i18n';

const MyDashboardCard = ( { showId } ) => {
    const [ open, setOpen ] = useState( false );
    const { data } = useQuery( {
        queryKey: [ 'my-addon-stats', showId ],
        queryFn:  () => window.wp.apiFetch( { path: `/my-addon/v1/stats/${ showId }` } ),
    } );

    return (
        <div className="bc-p-4 bc-border bc-rounded">
            <button onClick={ () => setOpen( ! open ) }>
                { __( 'My Add-on Stats', 'my-addon' ) }
            </button>
            { open && <p>{ data?.total ?? '—' }</p> }
        </div>
    );
};

wp.domReady( () => {
    window.BenecasterExtensions?.registerFill( 'BenecasterDashboardCards', MyDashboardCard );
} );

// Named slots and their fillProps:
// BenecasterEpisodePrePublish        — { episode_id, show_id }
// BenecasterEpisodeEditorTab_{id}    — { episodeId, showId }
// BenecasterEpisodeEditorAfterFields — { episodeId, showId }
// BenecasterShowEditorAfterFields    — { showId }
// BenecasterDashboardCards           — { showId }
// BenecasterSettingsPage_{id}        — no props (install-wide Settings screen)
// BenecasterShowSettingsPage_{id}    — { showId } (one show's settings)
// BenecasterSubscriberDetailAfter    — { subscriberId, showId }
