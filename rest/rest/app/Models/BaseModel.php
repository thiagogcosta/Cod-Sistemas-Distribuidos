<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	public $timestamps = false;

	public static function getTableName()
	{
		return with(new static)->getTable();
	}
}
