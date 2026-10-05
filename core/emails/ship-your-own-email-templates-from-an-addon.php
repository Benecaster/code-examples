<?php
// Ship your own email templates from an add-on

add_action(
    'benecaster_boot',
    function ( \Benecaster\Container $container ): void {
        $container
            ->make( \Benecaster\Email\EmailRenderer::class )
            ->add_template_dir( MY_ADDON_DIR . 'templates/emails' );
    }
);
