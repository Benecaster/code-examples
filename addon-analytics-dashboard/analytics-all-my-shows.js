// Read every Analytics Dashboard route for All my shows

const base = window.benecasterAnalyticsDashboard.apiUrl;
const headers = { 'X-WP-Nonce': window.benecasterAdmin.nonce };
const scope = await ( await fetch( base + 'analytics/scope?show_id=12', { headers } ) ).json();
// { show_id: 12, shows: [ { show_id: 12, name: 'Morning Show' }, … ], left_out: { switched_off: 1, archived: 2 } }
const growth = await ( await fetch( base + 'analytics/growth?show_id=12&scope=all&date_from=2026-10-01&date_to=2026-10-30', { headers } ) ).json();
