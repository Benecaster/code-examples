<?php
// Sell episode access from your own add-on, without storing it in Benecaster

add_filter(
    'benecaster_entitlement_grant_slugs',
    function ( array $slugs, int $user_id, int $show_id ): array {
        // Your own record of what this person owns on this show. Return the
        // NAMED sets they are entitled to — a product or a bundle — never a
        // per-person list of episode IDs.
        foreach ( my_addon_products_owned( $user_id, $show_id ) as $product_slug ) {
            $slugs[] = $product_slug;
        }

        return $slugs;
    },
    10,
    3
);
