<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerusahaanController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if ($user == null) { return Helper::responseErrorNoUser(); }

        // check user
        if ($user->id_perusahaan != null) { return Helper::responseError('User sudah terdaftar'); }

        DB::beginTransaction();
        try {

            // insert perusahaan
            $kode = Helper::generateRandomString(20);
            $model = new Perusahaan;
            $model->kode = $kode;
            $model->nama = $request->nama;
            $model->email = $request->email;
            $model->telp = $request->telp;
            $model->whatsapp = $request->whatsapp;
            $model->alamat = $request->alamat;
            $model->save();

            // update user
            $user = User::find($userId);
            $user->id_perusahaan = $model->id;
            $user->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        return Helper::responseSuccess();
    }
}
