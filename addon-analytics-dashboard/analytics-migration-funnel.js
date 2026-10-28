// Read the Analytics Dashboard migration funnel

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/migration-funnel?show_id=12';
const funnel = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
if ( ! funnel.available || funnel.batches.length === 0 ) {
    // Nothing to show: no Migration Wizard, or no migration on these shows. Do not say which.
}
// funnel.batches[0] → { show_id: 12, show_name: 'Night Shift', id: 4, source_platform: 'patreon', import_date: '2026-09-01T10:00:00+00:00',
//   imported: 40, completed: 12, dropped: 3, pending: 25, grace_period_days: 30, grace_ends_at: '2026-10-01T10:00:00+00:00',
//   status: 'active', records_free_tiers: true }
// funnel.totals → { imported: 40, completed: 12, dropped: 3, pending: 25 }
