// Read the Analytics Dashboard revenue by tier

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/revenue?show_id=12&date_from=2026-07-01&date_to=2026-09-30';
const revenue = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
if ( ! revenue.built_in ) {
    // No show in view uses built-in membership: Benecaster cannot see an external plugin's billing.
}
for ( const c of revenue.currencies ) {          // one currency at a time — never add c.total across entries
    const money = new Intl.NumberFormat( undefined, { style: 'currency', currency: c.currency, minimumFractionDigits: c.decimals, maximumFractionDigits: c.decimals } );
    console.log( c.currency, money.format( c.total ), c.tiers.map( ( t ) => [ t.tier_slug, money.format( t.amount ) ] ), money.format( c.buyups ) );
    // c.months → [ { month: '2026-07', amount_minor: null, amount: null }, { month: '2026-08', amount_minor: 1000, amount: 10 }, … ]
}
