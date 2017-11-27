<?php
namespace Database\Migrate\Mongodb;

use App\MongoModels;
use Illuminate\Database\Seeder AS Base;
use Illuminate\Support\Facades\File;

class Seeder extends Base
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$this->migrate();
	}

	public function migrate(){

		$files   = File::files(database_path()."/Migrate/Mongodb/Seeds");
		$current = MongoModels\Migration::query()->max('version');

		foreach( $files AS $file ){

			$pieces   = explode('/', $file);
			$filename = str_replace( '.php', '', end($pieces) );
			$version  = filter_var($filename, FILTER_SANITIZE_NUMBER_INT);

			if( $current < $version ){
				$class   = "Database\\Migrate\\Mongodb\\Seeds\\$filename";
				$migrate = new $class;
				$migrate->run();

				$migration = new MongoModels\Migration();
				$migration->fill(['version' => implode("_", str_split($version, 1))]);
				$migration->save();

				$current = $version;
			}
		}
	}
}
