<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;

abstract  class BaseController extends Controller
{
	public function __construct (){}

	protected function dataFormat($model){
		return [ 'data' => is_object($model) ? $model->toArray() : $model ];
	}

	/**
	 * @param $model
	 * @return \Illuminate\Pagination\LengthAwarePaginator
	 */
	public function paginate($model) {
		$per_page = (int) request()->input('per_page', 20);
		if (empty($per_page))
			$per_page = 20;

		if ($per_page > 500)
			$per_page = 500;

		/** @var \Illuminate\Database\Eloquent\Collection */

		/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
		$paginator = $model->paginate($per_page);
		$paginator->appends(\Illuminate\Support\Facades\Input::except('page'));
		return $paginator;
	}

	/**
	 * @param null $fields
	 * @return array
	 */
	public function validatorRules($rules, $fields = null)
	{
		if (empty($fields)) {
			return $rules;
		}

		$arr = [];

		foreach ($fields AS $key => $val) {
			if (isset($rules[$key])) {
				$arr[$key] = $rules[$key];
			}
		}

		return $arr;
	}
}
