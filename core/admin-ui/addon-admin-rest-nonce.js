// Send authenticated requests from an add-on's admin screen without a stale nonce

async function myAddonFetch( path, init = {} ) {
    const send = () => fetch( `/wp-json/my-addon/v1/${ path }`, {
        ...init,
        credentials: 'same-origin',
        // Read at send time: Benecaster may have renewed it since the last call.
        headers: { 'Content-Type': 'application/json', ...init.headers, 'X-WP-Nonce': window.benecasterAdmin.nonce },
    } );

    let response = await send();
    if ( 403 === response.status ) {
        const { code } = await response.clone().json().catch( () => ( {} ) );
        if ( 'rest_cookie_invalid_nonce' === code && window.benecasterAdmin.ajaxUrl ) {
            const fresh = ( await ( await fetch( `${ window.benecasterAdmin.ajaxUrl }?action=rest-nonce`, { credentials: 'same-origin' } ) ).text() ).trim();
            if ( /^[a-f0-9]{10}$/.test( fresh ) ) {
                window.benecasterAdmin.nonce = fresh;
                response = await send();
            }
        }
    }
    return response;
}
