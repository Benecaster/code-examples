<?php
// Read Outlinks' link-click totals by channel over REST, as the Analytics screen's Link clicks box does

const url = `${ wpApiSettings.root }benecaster-outlinks/v1/shows/${ showId }/clicks?date_from=2026-11-01&date_to=2026-11-30`;
const summary = await fetch( url, { headers: { 'X-WP-Nonce': wpApiSettings.nonce }, credentials: 'same-origin' } ).then( ( r ) => r.json() );
// summary.by_referrer.rss: clicks from podcast apps, through the feed's show notes.
