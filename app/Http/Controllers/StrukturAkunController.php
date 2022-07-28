<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\Perusahaan;
use App\Models\StrukturAkun;
use App\Models\StrukturAkunDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StrukturAkunController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        if (empty($user)) { return Helper::responseErrorNoUser(); }
        $perusahaan = Perusahaan::find($user->id_perusahaan);
        if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

        $query = StrukturAkun::where('id_perusahaan', '=', $perusahaan->id);
        if (isset($request->filter)){
            $query = $query->where('nama', 'like', '%'.$request->filter.'%');
        }
        $totalRowCount = $query->count();
        $models = $query->simplePaginate(30);
        return Helper::responseList($models, $totalRowCount);
    }

    public function show($id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = StrukturAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = StrukturAkunDetail::where('id_struktur_akun', '=', $model->id)->get();
            $model['detail'] = $detail;

            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try{
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            DB::beginTransaction();
            $model = new StrukturAkun;
            $model->id_perusahaan = $perusahaan->id;
            $model->nama = $request->nama;
            $model->jenis = $request->jenis;
            $model->keterangan = $request->keterangan;
            $model->save();

            // insert
            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $detail = new StrukturAkunDetail;
                $detail->id_struktur_akun = $model->id;
                $detail->nama = $item['nama'];
                $detail->cash = $item['cash'];
                $detail->bank = $item['bank'];
                $detail->save();
            }
            DB::commit();
        } catch (Exception $ex){
            DB::rollback();
            return Helper::responseError($ex->getMessage());
        }
        return Helper::responseSuccess($model);
    }

    public function update(Request $request, $id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = StrukturAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = StrukturAkunDetail::where('id_struktur_akun', '=', $model->id)->get();

            DB::beginTransaction();

            $model->nama = $request->nama;
            $model->jenis = $request->jenis;
            $model->keterangan = $request->keterangan;
            $model->save();

            // delete detail
            for ($i = 0; $i < count($detail); $i++) {
                $has = Helper::findObjectById($request->detail, $detail[$i]->id);
                if (!$has){
                    StrukturAkunDetail::where('id_struktur_akun', '=', $model->id)->find($detail[$i]->id)->delete();
                }
            }

            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $has = Helper::findObjectById($detail, $item['id']);

                if (!$has){

                    // add detail
                    $DbItem = new StrukturAkunDetail;
                    $DbItem->id_struktur_akun = $model->id;
                    $DbItem->nama = $item['nama'];
                    $DbItem->cash = $item['cash'];
                    $DbItem->bank = $item['bank'];
                    $DbItem->save();

                }else{

                    // update detail
                    $DbItem = StrukturAkunDetail::where('id_struktur_akun', '=', $model->id)->find($has->id);
                    $DbItem->nama = $item['nama'];
                    $DbItem->cash = $item['cash'];
                    $DbItem->bank = $item['bank'];
                    $DbItem->save();

                }
            }

            DB::commit();
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            DB::rollBack();
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

            $model = StrukturAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = StrukturAkunDetail::where('id_struktur_akun', '=', $model->id);

            DB::beginTransaction();

            $detail->delete();
            $model->delete();

            DB::commit();
            return Helper::responseSuccess();
        } catch (Exception $ex){
            DB::rollBack();
            return Helper::responseError($ex->getMessage());
        }
    }
}
