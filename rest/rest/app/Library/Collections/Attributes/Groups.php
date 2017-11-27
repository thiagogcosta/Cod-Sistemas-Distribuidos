<?php
namespace App\Library\Collections\Attributes;

use \Illuminate\Database\Eloquent\Collection;

class Groups extends Collection{

	/**
	 * @return Collection
	 * */
	public function attributesToArray(){

		$collection = new Collection();

		foreach($this->items AS $item){
			$collection = $collection->concat($item->attrs);
		}

		return $collection;
	}
}