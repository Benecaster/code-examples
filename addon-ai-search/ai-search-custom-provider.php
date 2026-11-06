<?php
// Add your own search provider to AI Search

use BenecasterAiSearch\Provider\{ AISearchProviderInterface, EmbeddingPurpose, ProviderErrorKind, ProviderException };

add_filter( 'benecaster_ai_search_providers', function ( array $providers ): array {
    $providers['localembed'] = [
        'label'   => __( 'Local Embed', 'my-plugin' ),
        'factory' => fn( string $api_key, array $settings ): AISearchProviderInterface => new My_Local_Embed_Provider( $api_key ),
    ];
    return $providers;
} );

final class My_Local_Embed_Provider implements AISearchProviderInterface {
    public function __construct( private string $key ) {}
    public function slug(): string { return 'localembed'; }
    public function label(): string { return __( 'Local Embed', 'my-plugin' ); }
    public function supports_indexing(): bool { return true; }
    public function model_id(): string { return 'localembed/mini-v1'; }
    public function max_batch_size(): int { return 16; }
    public function max_input_tokens(): int { return 512; }

    public function embed( array $texts, EmbeddingPurpose $purpose ): array {
        $response = wp_safe_remote_post( 'https://embed.example.internal/v1/embed', [
            'timeout' => 30,
            'headers' => [ 'Authorization' => 'Bearer ' . $this->key, 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode( [ 'input' => $texts, 'kind' => $purpose->value ] ),
        ] );
        $code = (int) wp_remote_retrieve_response_code( $response );
        if ( is_wp_error( $response ) || $code >= 500 ) {
            throw new ProviderException( ProviderErrorKind::Unavailable, __( 'Local Embed could not be reached.', 'my-plugin' ) );
        }
        if ( 401 === $code ) {
            throw new ProviderException( ProviderErrorKind::Auth, __( 'Local Embed did not accept the API key.', 'my-plugin' ), 401 );
        }
        $vectors = json_decode( wp_remote_retrieve_body( $response ), true )['vectors'] ?? null;
        if ( ! is_array( $vectors ) || count( $vectors ) !== count( $texts ) ) {
            throw new ProviderException( ProviderErrorKind::InvalidResponse, __( 'Local Embed sent an answer that could not be read.', 'my-plugin' ) );
        }
        return $vectors;
    }

    public function rank( string $query, array $candidates ): array {
        throw new ProviderException( ProviderErrorKind::Unsupported, __( 'Local Embed builds an index; it does not rank.', 'my-plugin' ) );
    }

    public function verify_credentials(): void {
        $this->embed( [ 'ping' ], EmbeddingPurpose::Query );
    }
}
