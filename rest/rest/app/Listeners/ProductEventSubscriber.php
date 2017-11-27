<?php
namespace App\Listeners;

use Illuminate\Database\Eloquent\Model;

class ProductEventSubscriber extends MongodbEventSubscriber
{
	protected $namespace = 'products';

    public function created(Model $model){
        $attributes = $model->toArrayWithAttrs();
        $mongoModel = $model->newMongoModel();

		$attributes['categories'] = $this->getCategories($model);

        unset($attributes['product_id']);



        $mongoModel->create($attributes);
    }

    public function updated(Model $model){
        $attributes = $model->toArrayWithAttrs();
        $mongoModel = $model->newMongoModel();

		$attributes['categories'] = $this->getCategories($model);

        unset($attributes['product_id']);
        unset($attributes['id']);
        $mongoModel->update($attributes);
    }

    public function getCategories(Model $model) {
		return $model->product->categories->pluck('id')->toArray();
	}
}