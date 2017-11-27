<?php
namespace App\Http\Controllers;

use App\Models;
use Illuminate\Support\Facades\DB;

class Product extends BaseController
{


	public function index()
	{
        try {
            return response("Método GET All", 200);
        } catch (\Exception $error) {
            return response(['error' => trans('error.unknown')], 500);
        }
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function show($id)
	{
        try {
            return response("Método GET Once", 200);
        } catch (\Exception $error) {
            return response(['error' => trans('error.unknown')], 500);
        }
	}

	public function store()
	{
        try {
            return response("Método POST", 200);
        } catch (\Exception $error) {
            return response(['error' => trans('error.unknown')], 500);
        }
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function update($id)
	{
        try {
            return response("Método UPDATE", 200);
        } catch (\Exception $error) {
            return response(['error' => trans('error.unknown')], 500);
        }
	}

	/**
	 * @param $id
	 * @return array
	 */
	public function destroy($id)
	{
        try {
            return response("Método DELETE", 200);
        } catch (\Exception $error) {
            return response(['error' => trans('error.unknown')], 500);
        }
	}
}
