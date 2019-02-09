<?php

require __DIR__.'/vendor/autoload.php';

/**
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !!!                                                    !!!
 * !!! Attention: Use PHP-7.0! PHP-7.1 is NOT compatible! !!!
 * !!!                                                    !!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */

//pass it a defaults key - these are options that'll be passed, by
//default, to each request. Set one option - exceptions - to false . Normally, if our server returns a 400 or 500
//status code, Guzzle blows up with an Exception. This makes it act normal - it'll return a Response always.
$client = new \GuzzleHttp\Client([
    'base_url' => 'http://localhost:8000',
    // 'base_uri' => 'http://localhost:8000',
	'defaults' => [
        'exceptions' => false
    ]
    // 'http_errors' => false
]);

// var_dump($client);die;

$response = $client->post('/api/programmers');

echo $response;
echo "\n\n";
