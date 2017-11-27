<?php

namespace Database\Migrate\Mysql\Seeds\Category;

use App\Models\Attributes;
use Illuminate\Database\Seeder;

class Seed_1_0_0 extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/**
		 * @var $entity Attributes\Entity
		 * */
		$entity = Attributes\Entity::create([
			'code'  => 'category',
			'table' => 'categories'
		]);

		$attributes = [
			'1' => $entity->attrs()->create([
				'code' 		 	=> 'name',
                'label'         => 'Nome',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'varchar'
			]),
			'2' => $entity->attrs()->create([
				'code' 		 	=> 'description',
                'label'         => 'Descrição',
				'validators' 	=> '',
				'frontend_type' => 'text',
				'backend_type'  => 'varchar'
			])
		];

		/**
		 * @var $set Attributes\EntitySet
		 * */
		$set = $entity->attr_set()->create([
			'name'    	=> 'Default',
			'default'	=> 'yes'
		]);

		$groups = [
			'1' => $set->groups()->create([
				'name'  => 'General',
				'order' => 1
			])
		];

		$relations_attributes_groups = [
			[
				'group' 	 => 1,
				'attributes' => [
					1 => [ 'order' => 1],
					2 => [ 'order' => 2]
				]
			],
		];

		foreach( $relations_attributes_groups AS $relation ){
			$ids = [];
			foreach ($relation['attributes'] AS $key => $options){
				$ids[$attributes[$key]->id] = $options;
			}
			$groups[$relation['group']]->attrs()->attach($ids);
		}
	}
}