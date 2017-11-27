<?php

namespace Database\Migrate\Mysql\Seeds\Product;

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
			'code'  => 'product',
			'table' => 'products_versions'
		]);

		$attributes = [
			'1' => $entity->attrs()->create([
				'code' 		 	=> 'type_product',
				'label'         => 'Tipo de Produto',
				'validators' 	=> 'required',
				'frontend_type' => 'select',
				'backend_type'  => 'varchar'
			]),
			'2' => $entity->attrs()->create([
				'code' 		 	=> 'name',
                'label'         => 'Nome do Produto',
                'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'varchar'
			]),
			'3' => $entity->attrs()->create([
				'code' 		 	=> 'total_value',
                'label'         => 'Valor do Curso Cheio',
				'validators' 	=> 'required',
				'frontend_type' => 'price',
				'backend_type'  => 'int'
			]),
			'4' => $entity->attrs()->create([
				'code' 		 	=> 'discount',
                'label'         => 'Desconto para ser Efetuado',
				'validators' 	=> 'required',
				'frontend_type' => 'text',
				'backend_type'  => 'varchar'
			]),
            '5' => $entity->attrs()->create([
                'code' 		 	=> 'installment',
                'label'         => 'Máximo de Parcelamento',
                'validators' 	=> 'required',
                'frontend_type' => 'number',
                'backend_type'  => 'decimal'
            ]),
            '6' => $entity->attrs()->create([
                'code' 		 	=> 'duration',
                'label'         => 'Duração (Meses)',
                'validators' 	=> 'required',
                'frontend_type' => 'number',
                'backend_type'  => 'decimal'
            ]),
            '7' => $entity->attrs()->create([
                'code' 		 	=> 'max_discount',
                'label'         => 'Desconto Máximo',
                'validators' 	=> 'required',
                'frontend_type' => 'text',
                'backend_type'  => 'varchar'
            ]),
            '8' => $entity->attrs()->create([
                'code' 		 	=> 'description',
                'label'         => 'Descrição do Produto',
                'validators' 	=> 'required',
                'frontend_type' => 'textarea',
                'backend_type'  => 'varchar'
            ]),
            '9' => $entity->attrs()->create([
                'code' 		 	=> 'bonus_description',
                'label'         => 'Descrição dos Bonus',
                'validators' 	=> 'required',
                'frontend_type' => 'textarea',
                'backend_type'  => 'varchar'
            ]),
            '10' => $entity->attrs()->create([
                'code' 		 	=> 'unit_approvation',
                'label'         => 'Aprovação da Unidade',
                'validators' 	=> 'required',
                'frontend_type' => 'boolean',
                'backend_type'  => 'decimal'
            ]),
            '11' => $entity->attrs()->create([
                'code' 		 	=> 'points_enable',
                'label'         => 'Habilitar Pontos',
                'validators' 	=> 'required',
                'frontend_type' => 'boolean',
                    'backend_type'  => 'decimal'
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
				'name'  => 'Geral',
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
                    5 => [ 'order' => 5],
                    6 => [ 'order' => 6],
                    7 => [ 'order' => 7],
                    8 => [ 'order' => 8],
                    9 => [ 'order' => 9],
                    10 => [ 'order' => 10],
                    11 => [ 'order' => 11],
				]
			],
		];

        $relations_attributes_options = [
            [
                'attribute'=> 1,
                'options'  => [
                    [
                        'label' => 'Presencial',
                        'value' => 'presential',
                        'position' => 1
                    ],
                    [
                        'label' => 'Online',
                        'value' => 'online',
                        'position' => 2
                    ]
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

        foreach( $relations_attributes_options AS $relation ){
		    $options = [];
            foreach ($relation['options'] AS $option){
                $options[] = new Attributes\Option($option);
            }
            $attributes[$relation['attribute']]->options()->saveMany($options);
        }
	}
}