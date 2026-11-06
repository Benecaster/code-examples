// Replace the episode editor's free guest rows with your own selector

function MyGuestPicker( { episodeId, showId, setDirty } ) {
    // Your own search-or-create UI; save through your own REST route.
    return window.BenecasterExtensions.React.createElement(
        'div',
        null,
        `Guests for episode ${ episodeId ?? '(new)' }`
    );
}

window.wp.domReady( () => {
    window.BenecasterExtensions?.registerFill?.( 'BenecasterEpisodeGuests', MyGuestPicker );
} );
