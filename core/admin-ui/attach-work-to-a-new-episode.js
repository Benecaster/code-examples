// Attach your add-on's work to a new episode once it has been saved

const pending = new Map(); // showId => what the podcaster picked on the new episode

window.addEventListener( 'benecaster:episode-created', async ( event ) => {
    const { episodeId, showId } = event.detail;
    const picks = pending.get( showId );
    if ( ! picks ) {
        return;
    }
    pending.delete( showId );
    await window.wp.apiFetch( {
        path: `/my-addon/v1/episodes/${ episodeId }/links`,
        method: 'POST',
        data: picks,
    } );
    myClearDirty(); // the setDirty( false ) your fill was given
} );
