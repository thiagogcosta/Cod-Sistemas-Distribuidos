<?php
namespace App\MongoModels;

use Moloquent\Auth\User AS Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
	protected $connection = 'mongodb';
	protected $collection = 'users';
	protected $fillable   = [];
	protected $guarded 	  = [];
	protected $primaryKey = 'id';
	public 	  $incrementing  = false;
	public 	  $timestamps 	 = false;

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

	public function getJWTIdentifier() {
		return $this->id;
	}

	public function getJWTCustomClaims() {
		return [
			'user' => [
				'id' 	=> $this->id,
				'name' 	=> $this->name,
				'email' => $this->email,
			],
			'guard' => 'user'
		];
	}
}
