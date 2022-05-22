<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if (empty($user)) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

        $query = Proyek::where('id_perusahaan', '=', $perusahaan->id);
        if ($request->filter){
            $query = $query->where('nama', 'like', '%'.$request->filter.'%');
        }
        $models = $query->simplePaginate(15);
        return Helper::responseSuccess($models);
    }

    public function store(Request $request)
    {
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
    }

    public function show($id)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if (empty($user)) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

        $model = Proyek::where('id_perusahaan', '=', $perusahaan->id)->find($id);
        if (empty($model)) return Helper::responseErrorNotFound();

        return Helper::responseSuccess($model);
    }

    public function update(Request $request, $id)
    {
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
    }

    public function destroy($id)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if (empty($user)) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

        $model = Proyek::where('id_perusahaan', '=', $perusahaan->id)->find($id);
        if (empty($model)) return Helper::responseErrorNotFound();

        $model->delete();

        return Helper::responseSuccess();
    }
}
