<?php
namespace App\Console\Commands;

use Illuminate\Database\Console\Seeds\SeedCommand;
use Symfony\Component\Console\Input\InputOption;

class MongodbSeeder extends SeedCommand {

	protected $name = 'db:mongodb_seed';

	public function __construct () {
		parent::__construct (app()['db']);
	}

	public function getOptions () {
		$options   = parent::getOptions (); // TODO: Change the autogenerated stub
		$options[] = ['app', null, InputOption::VALUE_OPTIONAL, 'The application id'];

		for( $i = 0, $j = count($options) ; $i < $j ; $i++){
			if($options[$i][0] == 'class'){
				$options[$i][4] = \Database\Migrate\Mongodb\Seeder::class;
				break;
			}
		}
		return $options;
	}
}