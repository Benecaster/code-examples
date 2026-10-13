// Add a Screen of Your Own to the Benecaster Admin

const EmailEditorScreen = ( { showId, path, navigate } ) => {
    if ( path === 'notifications' ) {
        return <Notifications showId={ showId } onBack={ () => navigate( '' ) } />;
    }
    if ( path.startsWith( 'templates/' ) ) {
        return <TemplateEditor showId={ showId } type={ path.slice( 10 ) } />;
    }
    return <TemplateList showId={ showId } onOpen={ ( type ) => navigate( `templates/${ type }` ) } />;
};

window.BenecasterExtensions?.registerFill( 'BenecasterAddonScreen_email-editor', EmailEditorScreen );
