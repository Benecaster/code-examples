<?php
// Read, change or log AI Search's search results

// Count zero-result searches per show, to see what listeners look for and do not find.
add_action( 'benecaster_ai_search_after_search', function ( string $query, int $show_id, array $results ): void {
    if ( [] === $results ) {
        $counts = (array) get_option( 'my_ai_search_misses', [] );
        $counts[ $show_id ] = ( $counts[ $show_id ] ?? 0 ) + 1;
        update_option( 'my_ai_search_misses', $counts, false );
    }
}, 10, 3 );

// A members-only site where every visitor is signed in can allow more searches a minute.
add_filter( 'benecaster_ai_search_rate_limit', fn( int $per_minute ): int => is_user_logged_in() ? 30 : $per_minute );

// A flagship show gets a higher daily limit on paid searches than the others.
add_filter( 'benecaster_ai_search_daily_cap', fn( int $cap, int $show_id ): int => 12 === $show_id ? 2000 : $cap, 10, 2 );
