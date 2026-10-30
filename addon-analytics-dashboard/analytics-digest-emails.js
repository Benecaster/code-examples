// Preview the Analytics Dashboard digest emails, or restyle them

const url = window.benecasterAnalyticsDashboard.apiUrl + 'analytics/digest/preview';
const preview = await ( await fetch( url, {
    method: 'POST',
    headers: { 'X-WP-Nonce': window.benecasterAdmin.nonce, 'Content-Type': 'application/json' },
    body: JSON.stringify( { show_id: 12, type: 'weekly' } ),
} ) ).json();
// { show_id, type, subject, html, text, would_send: true, reason: null }
