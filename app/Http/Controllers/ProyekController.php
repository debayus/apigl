<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\Proyek;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $query = Proyek::where('id_perusahaan', '=', $perusahaan->id);
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

    public function show($id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = Proyek::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = new Proyek;
            $model->id_perusahaan = $perusahaan->id;
            $model->nama = $request->nama;
            $model->save();
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = Proyek::where('id_perusahaan', '=', $perusahaan->id)->find($id);
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
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = Proyek::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $model->delete();

            return Helper::responseSuccess();
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }
}
