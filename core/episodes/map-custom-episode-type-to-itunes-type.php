<?php
// Map a custom episode type to a canonical iTunes type

add_filter(
    'benecaster_episode_itunes_type',
    function ( string $itunes_type, string $custom_slug, int $episode_id, int $show_id ): string {
        // Map site-defined types to the three canonical iTunes values.
        // Anything not covered here keeps the resolved value from the admin mapping.
        $map = [
            'interview'  => 'full',
            'deep-dive'  => 'full',
            'preview'    => 'trailer',
            'q-and-a'    => 'bonus',
            'commentary' => 'bonus',
        ];
        return $map[ $custom_slug ] ?? $itunes_type;
    },
    10,
    4
);
