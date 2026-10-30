// Read the Analytics Dashboard win-back drill-down

const base = window.benecasterAnalyticsDashboard.apiUrl;
const headers = { 'X-WP-Nonce': window.benecasterAdmin.nonce };
const list = await ( await fetch( base + 'analytics/winback?show_id=12&days=14&app=Overcast', { headers } ) ).json();
if ( ! list.available ) {
    // The feed request log is switched off: no data, not "nobody".
}
// list.total → everyone in the last 14 days; list.by_tier / by_app / by_show count them all
// list.count and list.leads → only those left after tier_slug and app
const trend = await ( await fetch( base + 'analytics/winback/trend?show_id=12&date_from=2026-09-01&date_to=2026-10-28', { headers } ) ).json();
for ( const p of trend.points ) {
    // p → { day: '2026-09-29', source: 'log', tokens: 2, polls: 6 }; never add p.tokens across days
}
