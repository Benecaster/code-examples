<?php
// Inject a React component into a named slot

// my-addon/resources/js/admin.js (compiled)
const MyDashboardCard = ({ showId }) => (
    <div className="p-4 border rounded">
        <h3>My Add-on Stats</h3>
        <p>Show ID: {showId}</p>
    </div>
);

wp.domReady( () => {
    window.BenecasterExtensions?.registerFill(
        'BenecasterDashboardCards',
        MyDashboardCard
    );
} );

// Named slots and their fillProps:
// BenecasterEpisodePrePublish        — { episode_id, show_id }
// BenecasterEpisodeEditorTab_{id}    — { episodeId, showId }
// BenecasterEpisodeEditorAfterFields — { episodeId, showId }
// BenecasterShowEditorAfterFields    — { showId }
// BenecasterDashboardCards           — { showId }
// BenecasterSettingsPage_{id}        — { showId }
// BenecasterSubscriberDetailAfter    — { subscriberId, showId }
