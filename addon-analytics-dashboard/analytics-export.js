// Download an Analytics Dashboard panel as CSV or the screen as PDF, and read its Your Data sheets

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/export?panel=revenue&show_id=12&date_from=2026-08-01&date_to=2026-10-31';
const response = await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } );
if ( ! response.ok ) {
    const error = await response.json(); // { code: 'benecaster_analytics_not_active', message, data: { status: 403 } }
}
const filename = /filename="([^"]+)"/.exec( response.headers.get( 'Content-Disposition' ) )[ 1 ]; // e.g. the-daily-dig-revenue-2026-08-01-to-2026-10-31.csv
const csv = await response.text(); // starts with a UTF-8 byte-order mark
