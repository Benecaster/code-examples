<?php
// Register a custom admin notice health check that runs once per admin session

use Benecaster\Notices\HealthChecks\HealthCheck;
use Benecaster\Notices\NoticeManager;

class StripeWebhookHealthCheck implements HealthCheck {

    private const NOTICE_ID = 'myaddon_health_stripe_webhook';

    public function __construct( private readonly NoticeManager $notices ) {}

    public function evaluate(): void {
        $last_seen = (int) get_option( 'myaddon_stripe_webhook_last_seen', 0 );

        // No webhook event in the last 24 hours and the gateway is connected → warn.
        if ( $last_seen > 0 && ( time() - $last_seen ) < DAY_IN_SECONDS ) {
            $this->notices->delete( self::NOTICE_ID );
            return;
        }

        $this->notices->publish( [
            'notice_id'    => self::NOTICE_ID,
            'type'         => 'warning',
            'display_mode' => 'both',
            'source'       => 'local',
            'title'        => __( 'Stripe webhooks have stopped', 'my-addon' ),
            'message'      => __( 'No Stripe webhook events received in the last 24 hours — verify your webhook endpoint.', 'my-addon' ),
            'action_url'   => admin_url( 'admin.php?page=myaddon-stripe' ),
            'action_label' => __( 'Open Stripe settings', 'my-addon' ),
            'dismissible'  => true,
        ] );
    }
}

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $notices = $container->make( NoticeManager::class );
    $notices->add_health_check( new StripeWebhookHealthCheck( $notices ) );
} );
