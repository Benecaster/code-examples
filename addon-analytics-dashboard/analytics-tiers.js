// Name and order a show's tiers the way the Analytics Dashboard does

const base = window.benecasterAnalyticsDashboard.apiUrl; // the add-on's own REST base, on Benecaster's admin page
const headers = { 'X-WP-Nonce': window.benecasterAdmin.nonce };
const { tiers } = await ( await fetch( base + 'analytics/tiers?show_id=12', { headers } ) ).json();
const names = Object.fromEntries( tiers.map( ( t ) => [ t.tier_slug, t.name ] ) );
