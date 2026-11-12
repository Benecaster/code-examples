<?php
// Offer AI models from the catalog in your add-on's settings, with your shipped list as the fallback

const MY_ADDON_SLUG    = 'benecaster-addon-my-ai-tool';
const MY_ADDON_VERSION = '1.4.0';

function my_addon_model_choices( string $provider, string $kind, array $shipped ): array {
    $choices = [];

    foreach ( benecaster_get_ai_model_catalog( $provider ) as $model ) {
        $needs = $model['min_addon_version'][ MY_ADDON_SLUG ] ?? null;
        if ( null === $needs || version_compare( MY_ADDON_VERSION, $needs, '<' ) ) {
            continue; // Not for this add-on, or needs a newer release of it.
        }
        if ( $model['kind'] !== $kind || $model['retired'] ) {
            continue;
        }
        // Prefer your own translated label when you ship this model too.
        $choices[ $model['id'] ] = $shipped[ $model['id'] ] ?? $model['label'];
    }

    return [] === $choices ? $shipped : $choices; // [] means "use your shipped list".
}
