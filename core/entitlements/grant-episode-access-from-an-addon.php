<?php
// Grant a listener access to an episode or a bundle from an add-on

// 1. Put episodes behind a grant slug. A slug is a NAMED set shared by every
//    holder — a product or a bundle — never a per-person episode list, because
//    the feed cache is keyed by slug. Availability rows are written exactly as
//    they are for a tier.
( new \Benecaster\Availability\AvailabilityRepository() )->upsert(
    $episode_id,
    $show_id,
    'season-one',            // the grant slug
    '2020-01-01 00:00:00'    // available from (site-local; upsert() converts to UTC)
);

// 2. Grant it to the buyer. Keyed to the PERSON, so it survives a token reset,
//    a cancellation and any change of subscriber type.
( new \Benecaster\Entitlement\EntitlementRepository() )->grant(
    user_id:      $user_id,
    show_id:      $show_id,
    grant_slug:   'season-one',
    expires_at:   null,                             // null = lifetime
    source:       'benecaster-addon-episode-sales', // your add-on's slug
    external_ref: $order_id                          // your order or payment id
);
