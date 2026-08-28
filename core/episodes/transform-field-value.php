<?php
// Transform a stored field value before display

add_filter( 'benecaster_field_value', function ( mixed $value, int $field_id, int $object_id, string $cpt_slug ): mixed {
    if ( null === $value ) {
        return $value;
    }

    // Example: format date fields as localized date strings.
    static $type_cache = [];
    if ( ! array_key_exists( $field_id, $type_cache ) ) {
        $definition = $GLOBALS['benecaster_container']
            ->make( \Benecaster\Fields\FieldRegistry::class )
            ->get_field( $field_id );

        $type_cache[ $field_id ] = $definition['field_type'] ?? null;
    }

    if ( 'date' === $type_cache[ $field_id ] ) {
        $timestamp = strtotime( (string) $value );
        return $timestamp ? date_i18n( get_option( 'date_format' ), $timestamp ) : $value;
    }

    return $value;
}, 10, 4 );
