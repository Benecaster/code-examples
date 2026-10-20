<?php
// Point the podcaster at a companion add-on the right way — buy, install or open it

$res  = rest_do_request( new WP_REST_Request( 'GET', '/benecaster/v1/addons' ) );
$rows = wp_list_pluck( $res->get_data()['items'] ?? [], null, 'entitlement_slug' );
$row  = $rows['benecaster-addon-ai-search'] ?? null;

if ( null === $row || $row['coming_soon'] ) {
    return; // Unknown or not released: say nothing, link nowhere.
}
if ( 'active' === $row['state'] ) {
    $href = $row['settings_url'] ?? null;            // Already running here.
} elseif ( isset( $row['purchase_url'] ) ) {
    $href = $row['purchase_url'];                    // Nobody here owns it.
} else {
    $href = admin_url( 'admin.php?page=benecaster#/settings/addons' ); // Owned: install it from Add-ons.
}
