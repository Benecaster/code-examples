<?php
// Decide something on the website from what the visitor holds

add_filter( 'the_content', static function ( string $content ): string {
    if ( ! is_singular( 'benecaster_episode' ) || ! function_exists( 'benecaster_get_user_holdings' ) ) {
        return $content;
    }

    $show_id  = (int) get_post_field( 'post_parent', get_the_ID() );
    $holdings = benecaster_get_user_holdings( $show_id ); // the current visitor
    $bonus    = benecaster_get_buyup_slug( (int) get_option( 'my_addon_bonus_buyup_id' ), $show_id );

    $allowed = [] !== array_intersect( [ 'gold', 'platinum' ], $holdings['tiers'] )
        || ( null !== $bonus && in_array( $bonus, $holdings['buyups'], true ) );

    return $allowed ? $content . my_addon_render_bonus( get_the_ID() ) : $content;
} );
