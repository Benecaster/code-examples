// Read the Analytics Dashboard Listener Support donations

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/donations?show_id=12&date_from=2026-10-01&date_to=2026-10-31';
const donations = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
if ( ! donations.available ) {
    // No donation in these dates for any show read.
}
// donations.count → 5, donations.unpriced → 1 (counted, in no currency)
for ( const c of donations.currencies ) {          // never add c.total across entries
    // c → { currency: 'USD', decimals: 2, count: 2, total_minor: 750, total: 7.5, points: [ { count: 1, amount_minor: 500, amount: 5 }, … ] }
}
