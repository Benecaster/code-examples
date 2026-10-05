<?php
// List an email job's failed recipients, and retry one safely

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ): void {
    $queue = $container->make( \Benecaster\Email\EmailQueue::class );

    add_action( 'rest_api_init', function () use ( $queue ): void {
        register_rest_route( 'my-addon/v1', '/jobs/(?P<id>\d+)/failed', [
            'methods'             => 'GET',
            'permission_callback' => fn () => current_user_can( 'manage_options' ),
            'callback'            => function ( \WP_REST_Request $request ) use ( $queue ) {
                $job  = absint( $request['id'] );
                $page = max( 1, absint( $request['page'] ?? 1 ) );
                return [
                    'items' => $queue->get_job_recipients( $job, 'my_addon_invite', 'failed', $page, 50 ),
                    'total' => $queue->count_job_recipients( $job, 'my_addon_invite', 'failed' ),
                ];
            },
        ] );

        register_rest_route( 'my-addon/v1', '/jobs/(?P<id>\d+)/failed/(?P<qid>\d+)/retry', [
            'methods'             => 'POST',
            'permission_callback' => fn () => current_user_can( 'manage_options' ),
            'callback'            => function ( \WP_REST_Request $request ) use ( $queue ) {
                $job = absint( $request['id'] );
                $qid = absint( $request['qid'] );
                // retry_single() does not check the job, so prove the row is ours first.
                $ours = wp_list_pluck(
                    $queue->get_job_recipients(
                        $job, 'my_addon_invite', 'failed', 1,
                        max( 1, $queue->count_job_recipients( $job, 'my_addon_invite', 'failed' ) )
                    ),
                    'queue_id'
                );
                if ( ! in_array( $qid, $ours, true ) || ! $queue->retry_single( $qid ) ) {
                    return new \WP_Error( 'not_retryable', 'Not a failed row of this job.', [ 'status' => 400 ] );
                }
                return [ 'success' => true ];
            },
        ] );
    } );
} );
