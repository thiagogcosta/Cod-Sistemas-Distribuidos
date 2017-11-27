<?php
namespace App\Library\Collections\Attributes;

use \Illuminate\Database\Eloquent\Collection;

class Entity extends Collection{

	public function getItems(){
		$arr = [];
		foreach($this->items AS $item){
			$arr[] = $item->toArrayWithAttrs();
		}
		return $arr;
	}
}