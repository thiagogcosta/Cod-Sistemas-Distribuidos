<?php
require_once __DIR__.'/vendor/autoload.php';

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;

// REGISTER

$app->register(new Silex\Provider\TwigServiceProvider(), [
	'twig.path' => __DIR__.'/views',
]);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'dbname' => 'server_side_api',
        'user' => 'root',
        'password' => '',
        'host' => '127.0.0.1',
        'driver' => 'pdo_mysql',
    ),
));

/**
 * @var $db \Doctrine\DBAL\Connection
 */
$db = $app['db'];


$app->post('/v1/data', function(Request $request) use($app, $db) {

    $req = $request->request->all();

    $url = 'https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/'.$req['id'];

// use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'GET'
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $app->json(json_decode($result));

})->bind('store-data');

$app->run();