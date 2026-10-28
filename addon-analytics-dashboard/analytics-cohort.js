// Read the Analytics Dashboard cohort retention matrix

const url = window.benecasterAnalyticsDashboard.apiUrl
    + 'analytics/cohort?show_id=12&date_from=2026-05-01&date_to=2026-10-28';
const matrix = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
// matrix.columns → 6
// matrix.cohorts[0] → { month: '2026-05', size: 40, retained: [ 38, 35, 33, 31, 30, 30 ], retained_pct: [ 95, 87.5, 82.5, 77.5, 75, 75 ] }
