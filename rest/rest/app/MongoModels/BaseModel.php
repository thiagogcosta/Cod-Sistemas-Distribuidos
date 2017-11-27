<?php
namespace App\MongoModels;

use Moloquent\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
	protected $connection = 'mongodb';
	protected $fillable   = [];
	protected $guarded 	  = [];
	protected $primaryKey = 'id';
	public $incrementing  = false;
	public $timestamps 	  = false;

	public function setIdAttribute($value){
		$this->attributes['id'] = $value ? intval($value) : $value;
	}

	public function getIdAttribute($value){
		return $value ? intval($value) : $value;
	}

	public function toArray(){
		$arr = parent::toArray();
		if(isset($arr['_id'])){
			unset($arr['_id']);
		}
		return $arr;
	}
}
