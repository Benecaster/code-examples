// Add a custom REST endpoint from your add-on
namespace MyAddon;

class MyController extends \Benecaster\REST\RestController {

    public function register_routes(): void {
        register_rest_route( self::NAMESPACE, '/my-resource', [
            'methods'             => 'GET',
            'callback'            => [ $this, 'get_resource' ],
            'permission_callback' => [ $this, 'permission_callback_admin' ],
        ] );
    }

    public function get_resource( \WP_REST_Request $request ): \WP_REST_Response {
        return new \WP_REST_Response( [ 'data' => 'hello from my add-on' ], 200 );
    }
}

add_action( 'benecaster_boot', function ( \Benecaster\Container $container ) {
    $container->make( \MyAddon\MyController::class )->register();
} );
