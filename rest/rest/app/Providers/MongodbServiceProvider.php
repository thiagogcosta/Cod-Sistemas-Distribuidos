<?php
namespace App\Providers;

use Moloquent\MongodbServiceProvider as Base;
use Moloquent\Queue\MongoConnector;

class MongodbServiceProvider extends Base{

	public function register()
	{
		// Add database driver.
		$this->app->resolving('db', function ($db) {
			$db->extend('mongodb', function ($config, $name) {
				$config['name'] = $name;
				return new \Moloquent\Connection($config);
			});
		});

		// Add connector for queue support.
		$this->app->resolving('queue', function ($queue) {
			$queue->addConnector('mongodb', function () {
				return new MongoConnector($this->app['db']);
			});
		});
	}
}