<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if ($user == null) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if ($perusahaan == null) return Helper::responseErrorNoPerusahaan();

        $models = Proyek::where('id_perusahaan', '=', $perusahaan->id)->simplePaginate(15);
        return Helper::responseSuccess($models);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if ($user == null) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if ($perusahaan == null) return Helper::responseErrorNoPerusahaan();

        $model = new Proyek;
        $model->id_perusahaan = $perusahaan->id;
        $model->nama = $request->nama;
        $model->save();
        return Helper::responseSuccess($model);
    }

    public function show($id)
    {
        $userId = auth()->user()->id;

        $model = Proyek::where('id_user', '=', $userId)->find($id);
        if(!empty($model))
        {
            return response()->json($model);
        }
        else
        {
            return response()->json([
                "message" => "not found"
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->user()->id;

        $model = Proyek::where('id_user', '=', $userId)->find($id);
        if ($model->exists()) {
            $model->nama = is_null($request->nama) ? $model->nama : $request->nama;
            $model->save();
            return response()->json([
                "message" => "Updated."
            ], 404);
        }else{
            return response()->json([
                "message" => "Not Found."
            ], 404);
        }
    }

    public function destroy($id)
    {
        $userId = auth()->user()->id;

        $model = Proyek::where('id_user', '=', $userId)->find($id);
        if($model->exists()) {
            $model->delete();

            return response()->json([
              "message" => "deleted."
            ], 202);
        } else {
            return response()->json([
              "message" => "not found."
            ], 404);
        }
    }
}
