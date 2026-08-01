<?php
// Drop a user's badge chips into a custom theme template

// Theme template (e.g. author.php) — display the post author's badges below their name.
$badges_html = benecaster_render_user_badges( (int) get_the_author_meta( 'ID' ) );
if ( '' !== $badges_html ) {
    // Output is already escaped by BadgeChipRenderer.
    echo $badges_html;
}
