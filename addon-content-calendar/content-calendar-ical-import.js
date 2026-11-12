// Import an .ics file into a show's Content Calendar over REST

const root = benecasterAdmin.apiUrl.replace( /benecaster\/v1\/?$/, '' );
const post = ( path, body ) => fetch( `${ root }benecaster-content-calendar/v1/shows/${ showId }/${ path }`, {
    method: 'POST',
    credentials: 'same-origin',
    headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': benecasterAdmin.nonce },
    body: JSON.stringify( body ),
} ).then( ( r ) => r.json() );

const { rows } = await post( 'ical/import/preview', { content } );
const chosen = rows.filter( ( r ) => r.ticked ).map( ( r ) => ( { index: r.index, type: r.type, type_name: r.type_name } ) );
const { created, failed } = await post( 'ical/import', { content, type: 'other', type_name: 'From my booking tool', rows: chosen } );
