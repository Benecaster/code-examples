// Show the taxed total in your own signup form

// `address` is Stripe's Address Element value: { line1, line2, city, state, postal_code, country }.
async function taxedTotal( showId, tierSlug, priceId, address ) {
    const res = await fetch( `/wp-json/benecaster/v1/shows/${ showId }/subscribe/tax-preview`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': wpApiSettings.nonce },
        body: JSON.stringify( { tier_slug: tierSlug, price_id: priceId, address } ),
    } );
    const body = await res.json();
    if ( 409 === res.status ) return null;                 // this show does not collect tax: no address needed
    if ( ! res.ok ) throw new Error( body.message );        // 422: Stripe could not place the address — ask again
    return body;                                            // { subtotal, tax, total, *_display } — minor units + strings
}
// Then send the same `address` with the signup:
// POST …/shows/{id}/subscribe { tier_slug, price_id, payment_method_id, address }
