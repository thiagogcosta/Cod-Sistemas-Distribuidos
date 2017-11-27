<?php
namespace App\MongoModels;

use Moloquent\Eloquent\HybridRelations;

class Category extends \App\MongoModels\BaseModel
{
	use HybridRelations;

	protected $collection = 'categories';

	public function children(){
		return $this->hasMany('App\MongoModels\Category', 'category_id', 'id');
	}

	public function setCategoryIdAttribute($value){
		$this->attributes['category_id'] = $value ? intval($value) : $value;
	}

	public function getCategoryIdAttribute($value){
		return $value ? intval($value) : $value;
		//		return intval($value);
	}

	public function loadCategoriesTree(){
		foreach ($this->children AS $category){
			$category->loadCategoriesTree();
		}
	}
}
