<?php
// Read or change what a guest said, in AI Search's answers to "what has [guest] said about [topic]?"

// Show one passage per episode, so a guest's words come from as many episodes as possible.
add_filter( 'benecaster_ai_search_guest_quotes', function ( array $quotes ): array {
    $seen = [];
    return array_values( array_filter( $quotes, function ( array $quote ) use ( &$seen ): bool {
        if ( isset( $seen[ $quote['episode_id'] ] ) ) {
            return false;
        }
        return $seen[ $quote['episode_id'] ] = true;
    } ) );
} );
