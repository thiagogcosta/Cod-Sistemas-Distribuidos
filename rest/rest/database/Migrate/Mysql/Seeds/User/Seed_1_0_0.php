<?php

namespace Database\Migrate\Mysql\Seeds\User;

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
			'code'  => 'user',
			'table' => 'users'
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
				'code' 		 	=> 'username',
                'label'         => 'Usuário',
				'validators' 	=> 'required|unique|min:4|max:20|username',
				'frontend_type' => 'text',
				'backend_type'  => 'varchar'
			]),
			'3' => $entity->attrs()->create([
				'code' 		 	=> 'email',
                'label'         => 'Email',
				'validators' 	=> 'required|unique|email',
				'frontend_type' => 'email',
				'backend_type'  => 'varchar'
			]),
			'4' => $entity->attrs()->create([
				'code' 		 	=> 'password',
                'label'         => 'Senha',
				'validators' 	=> 'required|min:6|confirmed',
				'frontend_type' => 'password',
				'backend_type'  => 'varchar'
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
			])
		];

		$relations_attributes_groups = [
			[
				'group' 	 => 1,
				'attributes' => [
					1 => [ 'order' => 1],
					2 => [ 'order' => 2],
					3 => [ 'order' => 3],
					4 => [ 'order' => 4],
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