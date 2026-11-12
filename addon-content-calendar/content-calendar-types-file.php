<?php
// Write a Content Calendar content types file a podcaster can load

$file = [
    'format'  => 'benecaster-content-calendar-types',
    'version' => 1,
    'types'   => [
        [ 'key' => 'tweet', 'built_in' => true, 'name' => 'Post on X', 'color' => '#000000', 'enabled' => true, 'uses_content' => true, 'content_limit' => 280 ],
        [ 'key' => '', 'built_in' => false, 'name' => 'Podcast Clip', 'color' => '#db2777', 'enabled' => true, 'uses_content' => true, 'content_limit' => 280 ],
    ],
];
file_put_contents( 'starter-types.json', wp_json_encode( $file, JSON_PRETTY_PRINT ) );
