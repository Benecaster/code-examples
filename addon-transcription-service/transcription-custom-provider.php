<?php
// Add your own transcription provider to Transcription Service

use BenecasterTranscription\Provider\{ ProviderErrorKind, ProviderException, Segment, SubmittedJob, TranscriptionProviderInterface, TranscriptionRequest, TranscriptResult, JobState };

add_filter( 'benecaster_transcription_providers', function ( array $providers ): array {
    $providers['speechco'] = [
        'label'   => __( 'SpeechCo', 'my-plugin' ),
        'factory' => fn( string $api_key, array $settings ): TranscriptionProviderInterface => new My_SpeechCo_Provider( $api_key ),
    ];
    return $providers;
} );

final class My_SpeechCo_Provider implements TranscriptionProviderInterface {
    public function __construct( private string $key ) {}
    public function slug(): string { return 'speechco'; }
    public function label(): string { return __( 'SpeechCo', 'my-plugin' ); }

    public function submit( TranscriptionRequest $request ): SubmittedJob {
        $response = wp_safe_remote_post( 'https://api.speechco.example/v1/transcribe', [
            'timeout' => 300,
            'headers' => [ 'Authorization' => 'Bearer ' . $this->key, 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode( [ 'url' => $request->audio_url, 'lang' => $request->language ] ),
        ] );
        $code = (int) wp_remote_retrieve_response_code( $response );
        if ( is_wp_error( $response ) || $code >= 500 ) {
            throw new ProviderException( ProviderErrorKind::Unavailable, __( 'SpeechCo could not be reached.', 'my-plugin' ) );
        }
        if ( 401 === $code ) {
            throw new ProviderException( ProviderErrorKind::Auth, __( 'SpeechCo did not accept the API key.', 'my-plugin' ), 401 );
        }
        $data     = json_decode( wp_remote_retrieve_body( $response ), true );
        $segments = array_map( fn( array $c ) => new Segment( $c['from'], $c['to'], $c['text'] ), $data['cues'] ?? [] );
        return SubmittedJob::completed( new TranscriptResult( 'speechco', $segments, [], $data['seconds'] ?? null, $data['lang'] ?? null ) );
    }

    // Synchronous: never called.
    public function poll( string $job_id ): JobState { throw new LogicException( 'synchronous' ); }
    public function fetch_result( string $job_id ): TranscriptResult { throw new LogicException( 'synchronous' ); }

    public function verify_credentials(): void { /* one free authenticated GET; throw ProviderErrorKind::Auth on 401 */ }
    public function supports_diarization(): bool { return false; }
    public function supports_language_hint(): bool { return true; }
    public function max_concurrency_hint(): int { return 2; }
}
