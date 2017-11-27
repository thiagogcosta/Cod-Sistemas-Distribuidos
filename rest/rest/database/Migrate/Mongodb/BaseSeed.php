<?php
namespace Database\Migrate\Mongodb;

use Illuminate\Support\Facades\DB;

class BaseSeed extends \Illuminate\Database\Seeder {

	/**
	 * @return \MongoDB\Database
	 * */
	public function getMongoDB(){
		/**
		 * @var $connection \Moloquent\Connection
		 * */
		$connection = DB::connection('mongodb');

		return $connection->getMongoDB();
	}
}