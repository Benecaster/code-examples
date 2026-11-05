// Read the Analytics Dashboard email engagement

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/email-engagement?show_id=12&date_from=2026-10-01&date_to=2026-10-31';
const email = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
if ( ! email.available ) {
    // The Email Editor is not on for any show read (or not installed): draw a placeholder, not an empty state.
}
// email.types.episode_notification → { sends: [ { show_id, show_name, type, send_id, title, sent_at, recipients, opened, opens, clicked, clicks, open_rate, click_rate }, … ],
//   totals: { sends: 2, recipients: 20, opened: 10, opens: 14, clicked: 3, clicks: 4, open_rate: 50, click_rate: 15 },
//   prior: { recipients: 10, opened: 4, …, open_rate: 40, click_rate: 0 }, change: { open_rate: 10, direction: 'up' },
//   tiers: [ { tier_slug: 'gold', recipients: 12, opened: 8, …, open_rate: 66.7, click_rate: 25 }, { tier_slug: '', … } ] }
// email.types.broadcast → the same shape, never added to the other.
