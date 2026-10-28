// Read the Analytics Dashboard tier breakdown and tier movement

const base = window.benecasterAdmin.apiUrl.replace( 'benecaster/v1/', 'benecaster-analytics/v1/' );
const q = 'show_id=12&date_from=2026-10-01&date_to=2026-10-30';
const headers = { 'X-WP-Nonce': window.benecasterAdmin.nonce };
const breakdown = await ( await fetch( base + 'analytics/tier-breakdown?' + q, { headers } ) ).json();
const movement = await ( await fetch( base + 'analytics/tier-movement?' + q, { headers } ) ).json();
// breakdown.total.change → { active: 18, active_pct: 7.9 }
// movement.moves[0]     → { from_tier: 'free', to_tier: 'basic', direction: 'upgraded', count: 8 }
