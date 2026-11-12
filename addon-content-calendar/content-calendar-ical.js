// Download a show's Content Calendar as iCal, or read its private subscription URL

// From an admin screen, with core's nonce.
const root = benecasterAdmin.apiUrl.replace( /benecaster\/v1\/?$/, '' );
const { filename, content } = await ( await fetch( `${ root }benecaster-content-calendar/v1/shows/${ showId }/ical`, {
    credentials: 'same-origin',
    headers: { 'X-WP-Nonce': benecasterAdmin.nonce },
} ) ).json();
