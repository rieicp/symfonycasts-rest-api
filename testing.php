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



// 1) Create a programmer resource
$nickname = 'ObjectOrienter'.rand(0, 999);
$data = array(
	'nickname' => $nickname,
	'avatarNumber' => 5,
	'tagLine' => 'a test dev!'
);

$response = $client->post('/api/programmers', [
	'body' => json_encode($data)
]);

$programmerUrl = $response->getHeader('Location');

echo $response;
echo "\n\n";


// 2) GET a programmer resource
$response = $client->get($programmerUrl);

echo $response;
echo "\n\n";
