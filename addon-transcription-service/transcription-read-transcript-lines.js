// Read an episode's transcript lines in an admin screen

const url = `${ window.wpApiSettings.root }benecaster-transcription/v1/shows/${ showId }/episodes/${ episodeId }/transcript`;
const response = await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } );
const { transcript } = await response.json(); // null until the transcript is complete
if ( transcript?.timed ) {
    for ( const line of transcript.lines ) {
        // line = { index, start, end, speaker, text }; start and end in seconds.
    }
}
