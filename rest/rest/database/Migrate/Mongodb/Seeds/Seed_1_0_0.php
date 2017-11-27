<?php
namespace Database\Migrate\Mongodb\Seeds;

class Seed_1_0_0 extends \Database\Migrate\Mongodb\BaseSeed{

	public function run(){

		$db = $this->getMongoDB();

		$db->createCollection('tests');
	}
}