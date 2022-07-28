<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\Test;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        try{
            $query = Test::query();
            if (isset($request->filter)){
                $query = $query->where('nama', 'like', '%'.$request->filter.'%');
            }
            $totalRowCount = $query->count();
            $models = $query->simplePaginate(30);
            return Helper::responseList($models, $totalRowCount);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
            $model = new Test;
            $model->nama = $request->nama;

            $model->save();
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $model = Test::find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $model = Test::find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $model->nama = $request->nama;

            $model->save();

            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $model = Test::query();
            if (empty($model)) return Helper::responseErrorNotFound();
            $model->delete();
            return Helper::responseSuccess();
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function add(Request $request)
    {
        try{
            for($i=0; $i < 10; $i++){
                $model = new Test;
                $model->nama = 'Test '.$i;
                $model->save();
            }
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }
}
