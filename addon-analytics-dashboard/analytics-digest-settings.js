// Read or change a show's Analytics Dashboard digest settings

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/digest/settings?show_id=12';
const { settings, recipient_choices, timezone } = await ( await fetch( url, { headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce } } ) ).json();
// settings = { paused: false, send_time: '09:00', recipients: [ 1 ],
//   daily: { enabled: false, threshold: 'on_change' }, weekly: { enabled: true, day: 5 }, monthly: { enabled: false, day: 1 } }
