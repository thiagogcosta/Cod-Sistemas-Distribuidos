<?php
namespace App\Library\Traits;

use App\Library\Exceptions\AttributeException;
use App\Models\Attributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait hasDynamicAttributes{

	public $_events = [];

	public function __construct(array $attributes = []){
		$events = ['creating', 'created', 'updating', 'updated', 'deleting', 'deleted'];

		$name = $this->getEventNamespace();
		foreach($events AS $event){
			$this->_events[$event] = "$name.$event";
		}

		parent::__construct($attributes);
	}

	public static function boot()
	{
		parent::boot();

		static::deleting(function ($item) {
			$groups = $item->attr_set->groups;
			foreach($groups AS $group){
				foreach($group->attrs AS $attribute){
					$attribute->values()->where('entity_id', $item->id)->delete();
				}
			}
		});
	}

    public function getEventNamespace(){
        return $this->getTable();
    }

	public function getMongoModel(){
	    return str_replace('Models', 'MongoModels', self::class);
    }

	public function newMongoModel(){

	    $class = $this->getMongoModel();
		$model = new $class;
		$item  = null;
		if( !empty($this->id) ){
			$item = $model->newQuery()->where('id', $this->id)->first();
		}
		return $item ? $item : $model;
	}

	public function newCollection(array $models = []){
		return new \App\Library\Collections\Attributes\Entity($models);
	}

	public function getIdAttribute($value){
		return intval($value);
	}

	public function attr_set(){
		return $this->belongsTo('\App\Models\Attributes\EntitySet', 'attributes_set_id');
	}

	public function loadAttributes(){

		$record = Attributes\EntitySet::query()
			->with('groups', 'groups.attrs')
			->where('id', $this->attributes_set_id)
			->first();

		foreach ($record->groups AS $group){
			foreach ($group->attrs AS $attribute){
				$attribute->load(['values' => function ($query) {
					$query->where('entity_id', $this->id);
				}]);
			}
		}

		return $record;
	}

	public function toArrayWithAttrs(){

		$arr      = $this->attributesToArray();
		$attr_set = $this->loadAttributes();

		foreach($attr_set->groups AS $group){
			foreach($group->attrs AS $attribute){
				$values = $attribute->values->pluck('value');
				$arr[$attribute->code] = $values->{$attribute->frontend_type == 'multiselect' ? 'all' : 'first'}();
			}
		}

		return $arr;
	}

	public function getRules($attributes){

		$rules = [];

		foreach($attributes AS $attribute){
			if(!empty($attribute->validators)){

				$validators = explode('|', $attribute->validators);

				if(($pos = array_search('unique', $validators)) !== false){

					$uq = Rule::unique('attributes_value_'.$attribute->backend_type,'value')
						->where('attribute_id', $attribute->id)
						->ignore($this->id, 'entity_id');

					$validators[$pos] = $uq;
				}

				$rules[$attribute->code] = $validators;
			}
		}

		return $rules;
	}

	public function validateAttributes($attributes, $values, $updating){
		$rules = $this->getRules($attributes);

		if($updating){
			$arr = [];
			foreach($values AS $key => $value){
				if(isset($rules[$key])){
					$arr[$key] = $rules[$key];
				}
			}
		}else{
			$arr = $rules;
		}

		$validator = Validator::make ($values, $arr);

		$validator->validate ($values);
	}

	public function createAttributesValues($values, $updating = false){

		$attributes = $this->attr_set->groups->attributesToArray();

		$this->validateAttributes($attributes, $values, $updating);

		foreach( $attributes AS $attribute ){

			if(isset($values[$attribute->code])){
				if($updating){
					$attribute->values()
						->where('entity_id', $this->id)
						->delete();
				}

				if (!empty($values[$attribute->code]) && $attribute->frontend_type == 'password') {
					$values[$attribute->code] = Hash::make($values[$attribute->code]);
				}

				$attribute->values()->create([
					'value' 	=> $values[$attribute->code] ? $values[$attribute->code] : null,
					'entity_id' => $this->id
				]);
			}
		}
	}

	public function splitValues($values){

		$arr = [
			'self_attributes' 	=> [],
			'custom_attributes' => [],
		];

		$fields = array_merge( $this->fillable, [self::UPDATED_AT, self::CREATED_AT] );
		foreach($values AS $key => $value){
			$arr[ in_array($key, $fields) ? 'self_attributes' : 'custom_attributes' ][$key] = $value;
		}

		if(empty($arr['self_attributes']['attributes_set_id'])){
            $arr['self_attributes']['attributes_set_id'] = $this->getDefaultAttrSet()->id;

        }else if(!$this->checkAttrSet($arr['self_attributes']['attributes_set_id'])){
			throw new AttributeException(trans('error.invalid-attr-set'));
		}

		return $arr;
	}

	public static function createWithAttrs($values){
		$instance = new self();
		$data     = $instance->splitValues($values);

		return DB::transaction(function() use($instance, $data){
			$instance->fill($data['self_attributes']);
			event($instance->_events['creating'], [$instance]);

			$instance->save();
			$instance->createAttributesValues($data['custom_attributes']);
			event($instance->_events['created'], [$instance]);

			return $instance;
		});
	}

	public function updateWithAttrs($values){

		$data = $this->splitValues($values);

		return DB::transaction(function() use($data){
			$this->fill($data['self_attributes']);
			event($this->_events['updating'], [$this]);

			$this->save();
			$this->createAttributesValues($data['custom_attributes'], true);
			event($this->_events['updated'], [$this]);

			return true;
		});
	}

	public function delete(){
		return DB::transaction(function(){
			event($this->_events['deleting'], [$this]);

			$res = parent::delete();
			event($this->_events['deleted'], [$this]);

			return $res;
		});
	}

	public static function checkAttrSet($id){

		$attr_set = Attributes\EntitySet::find($id);
		if(empty($attr_set)){
			throw new AttributeException(trans('error.attribute-set-not-found'));
		}

		$table = with(new static())->getTable();
		return $attr_set->entity()
			->whereRaw("`table` = '$table'")
			->count();
	}

	public static function getDefaultAttrSet()
	{
		$table = with(new static())->getTable();
		$query = Attributes\Entity::query()
			->select('id')
			->whereRaw("`table` = '$table'")
			->toSql();

		$set = Attributes\EntitySet::query()
			->whereRaw("attributes_entity_type_id = ($query)")
			->where('default', 'yes')
			->first();

		if(empty($set)){
			throw new AttributeException('Default attribute set not found');
		}

		return $set;
	}
}