<?php
// Ask whether this install is staging — and know which question you are asking

use Benecaster\Staging\EnvironmentDeclaration;
use Benecaster\Staging\EnvironmentResolver;
use Benecaster\Staging\StagingManager;

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    // The ordinary question: should my add-on hold back from doing
    // anything that touches real customers on this install?
    if ( $container->make( StagingManager::class )->is_staging() ) {
        add_filter( 'my_addon_send_real_emails', '__return_false' );
    }

    // The narrower question: was that DECLARED, or merely detected?
    // Useful when you want to warn about a guess but trust a decision.
    $declared = $container->make( EnvironmentResolver::class )->declared();

    if ( EnvironmentDeclaration::Undeclared === $declared ) {
        // Nobody said. Core fell through to hostname detection, which
        // can be wrong in both directions — surface it rather than
        // silently acting on it.
        my_addon_log( 'Environment was detected, not declared.' );
    }
} );
