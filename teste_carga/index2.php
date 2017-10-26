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

// ROUTES
$app->get('/', function () use ($app) {
	return $app['twig']->render('index.twig', []);
});

$app->get('/v1/data', function() use($app, $db) {

    $sql = $db->createQueryBuilder()
        ->select('*')
        ->from('data');

    $data = $db->fetchAll($sql);

    $result = [
        'success' => $data,
    ];

    return $app->json($result);

})->bind('index-data');

$app->get('/v1/data/{id}', function($id) use($app, $db) {

    $sql = $db->createQueryBuilder()
        ->select('*')
        ->from('data')
        ->where('id = '.$id);

    $data = $db->fetchAll($sql);

    $result = [
        'success' => $data,
    ];

    return $app->json($result);

})->bind('show-data');

$app->post('/v1/data', function(Request $request) use($app, $db) {

    $result = [
        'success' => $db->insert('data', $request->request->all()),
    ];

    return $app->json($result);

})->bind('store-data');

$app->put('/v1/data/{id}', function($id, Request $request) use($app, $db) {

    $params = $request->request->all();
    $query  = "UPDATE data SET title = ?, data = ? WHERE id = ?";

    $result = [
        'success' => $db->executeUpdate($query, array($params['title'], $params['data'], (int) $id))
    ];

    return $app->json($result);

})->bind('update-data');

$app->delete('/v1/data/{id}', function($id) use($app, $db) {

    $result = [
        'success' => $db->delete('data', array('id' => $id)),
    ];

    return $app->json($result);

})->bind('destroy-data');

$app->run();