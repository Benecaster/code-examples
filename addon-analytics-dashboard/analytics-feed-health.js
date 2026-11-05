// Read the Analytics Dashboard feed health history

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/feed-health?show_id=12&date_from=2026-09-01&date_to=2026-09-14';
const health = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
// health.shows[0] → { show_id: 12, show_name: 'Night Shift', syncs: true, first_checked: '2026-09-01', last_checked: '2026-09-14',
//   totals: { days: 14, checked: 11, valid: 7, invalid: 4, unchecked: 3, sync_runs: 43, sync_failures: 3 },
//   problems: [ { code: 'item_duration_invalid', label: 'An episode’s duration is not written as hours, minutes and seconds', known: true, days: 2, last_day: '2026-09-05' }, … ],
//   days: [ { date: '2026-09-01', state: 'valid', error_count: 0, first_error_code: null, first_error_label: null,
//             episode_count: 12, feed_size_bytes: 48000, sync_runs: 4, sync_failures: 0, checked_at: '2026-09-02 00:15:00' }, … ] }
