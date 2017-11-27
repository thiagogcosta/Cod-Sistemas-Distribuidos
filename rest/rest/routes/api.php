<?php
/** @var \Dingo\Api\Routing\Router $api */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function () use ($api) {

    $api->get('teste', function(){
        die('aqui');
    });

	$api->group([
		'namespace' => 'App\Http\Controllers'
	],function() use ($api) {

        $api->resource('products', 'Product', ['only' => [
            'index', 'show', 'store', 'update', 'destroy'
        ]]);
	});
});
