<?php
namespace Database\Migrate\Mysql;

use Illuminate\Database\Seeder AS Base;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Seeder extends Base
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->migrate();
	}

	public function migrate(){

		/**
		 * @var $connection \Illuminate\Database\MySqlConnection
		 * */
		$connection = DB::connection();

		$types = array_map(function($value){
			$pieces = explode('/', $value);
			return trim(end($pieces));
		}, File::directories(database_path().'/Migrate/Mysql/Seeds'));

		foreach ($types AS $type){

			$versions = $this->getFolderVersions($type);
			if(!empty($versions)){

				$current = filter_var( $this->getVersion($type), FILTER_SANITIZE_NUMBER_INT );
				foreach ($versions as $version => $filename)
				{
					if($current < $version){
						$connection->transaction(function() use($connection, $type, $filename, $version){
							$this->call( "Database\\Migrate\\Mysql\\Seeds\\$type\\$filename");

							$connection
								->query()
								->from('seed_migration')
								->where('namespace', strtolower($type))
								->update(['version' => implode("_", str_split($version, 1))]);
						});

						$current = $version;
					}
				}
			}
		}
	}

	public function getFolderVersions($folder)
	{
		$versions      = [];
		$filesInFolder = File::files(database_path().'/Migrate/Mysql/Seeds/'.$folder);

		foreach($filesInFolder as $path)
		{
			$pieces   = explode('/',$path);
			$filename = str_replace('.php', '', end($pieces));
			$version  = filter_var($filename, FILTER_SANITIZE_NUMBER_INT);
			$versions[$version] = $filename;
		}

		return $versions;
	}

	private function getVersion($namespace){

		$connection = DB::connection();

		$result = $connection
			->query()
			->from('seed_migration')
			->select('version')
			->where('namespace', strtolower($namespace))
			->orderBy('version', 'desc')
			->first();

		if (empty($result)){
			$connection
				->query()
				->from('seed_migration')
				->insert(['version' => 0, 'namespace' => strtolower($namespace)]);

			return 0;
		}
		return $result->version;
	}
}
