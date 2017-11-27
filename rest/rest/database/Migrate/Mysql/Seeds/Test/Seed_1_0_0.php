<?php

namespace Database\Migrate\Mysql\Seeds\Test;

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
			'code'  => 'test',
			'table' => 'tests'
		]);

		$attributes = [
			'1' => $entity->attrs()->create([
				'code' 		 	=> 'price',
                'label'         => 'Preço',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'decimal'
			]),
			'2' => $entity->attrs()->create([
				'code' 		 	=> 'title',
                'label'         => 'Título',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'text'
			]),
			'3' => $entity->attrs()->create([
				'code' 		 	=> 'sku',
                'label'         => 'SKU',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'text'
			]),
			'4' => $entity->attrs()->create([
				'code' 		 	=> 'description',
                'label'         => 'Descrição',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'text'
			]),
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
			]),
			'2' => $set->groups()->create([
				'name'  => 'Price',
				'order' => 2
			])
		];

		$relations_attributes_groups = [
			[
				'group' 	 => 1,
				'attributes' => [
					2 => [ 'order' => 1],
					3 => [ 'order' => 2],
					4 => [ 'order' => 3],
				]
			],
			[
				'group' 	 => 2,
				'attributes' => [
					1 => [ 'order' => 1]
				]
			]
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