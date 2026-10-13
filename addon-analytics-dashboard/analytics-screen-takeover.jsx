// Draw the Analytics Screen from the Analytics Dashboard Add-on

const AnalyticsScreen = ( { showId, path } ) => {
    if ( path === 'settings' ) {
        return <AnalyticsSettings showId={ showId } />;
    }
    return <AnalyticsOverview showId={ showId } />;
};

window.BenecasterExtensions?.registerFill( 'BenecasterAnalyticsScreen', AnalyticsScreen );
