<?php
// Let buy-up holders through a tier gate

add_filter(
    'benecaster_tier_gate_passes',
    function ( bool $passes, int $show_id, string $min_tier, string $user_tier ): bool {
        // Already in on tier, or not a gate this snippet is about.
        if ( $passes || 'growth' !== $min_tier ) {
            return $passes;
        }

        // The buy-up's row ID in benecaster_buyups (here, "Transcripts").
        $transcripts_buyup_id = 12;

        // 0 = the current user. Passing $show_id scopes the grant to the
        // show the gate is on, so a buy-up bought on another show can't open it.
        return benecaster_user_has_buyup( 0, $transcripts_buyup_id, $show_id );
    },
    10,
    4
);
