<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Helper;
use App\Models\KonsepAkun;
use App\Models\KonsepAkunDetail;
use App\Models\Perusahaan;
use App\Models\StrukturAkun;
use App\Models\StrukturAkunDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $query = Akun::where('id_perusahaan', '=', $perusahaan->id);
            $filter = $request->filter;
            if ($filter){
                $query = $query->where(function ($query) use ($filter) {
                    return $query
                        ->where('nama', 'like', '%'.$filter.'%')
                        ->orWhere('no', 'like', '%'.$filter.'%');
                });
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

            $model = Akun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
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

            $model = new Akun;
            $model->id_perusahaan = $perusahaan->id;
            $model->komponen = $request->komponen;
            $model->id_struktur_akun = $request->id_struktur_akun;
            $model->id_struktur_akun_detail = $request->id_struktur_akun_detail;
            $model->normalpos = $request->normalpos;
            $model->level = $request->level;
            $model->no = $request->no;
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

            $model = Akun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $model->komponen = $request->komponen;
            $model->id_struktur_akun = $request->id_struktur_akun;
            $model->id_struktur_akun_detail = $request->id_struktur_akun_detail;
            $model->normalpos = $request->normalpos;
            $model->level = $request->level;
            $model->no = $request->no;
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

            $model = Akun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $model->delete();

            return Helper::responseSuccess();
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function master(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            // struktur akun
            $strukturAkun = StrukturAkun::where('id_perusahaan', '=', $perusahaan->id)->get();

            // struktur akun detail
            $strukturAkunId = [];
            foreach ($strukturAkun as $element) {
                array_push($strukturAkunId, $element['id']);
            }
            $strukturAkunDetail = StrukturAkunDetail::whereIn('id_struktur_akun', $strukturAkunId)->get();

            // konsep akun
            $konsepAkun = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id)->first();

            // konsep akun detail
            $konsepAkunDetail = $konsepAkun == null ? [] :KonsepAkunDetail::where('id_konsep_akun', '=', $konsepAkun['id'])->get();

            return Helper::responseSuccess([
                'strukturAkun' => $strukturAkun,
                'strukturAkunDetail' => $strukturAkunDetail,
                'konsepAkunDetail' => $konsepAkunDetail,
            ]);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function all(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $query = Akun::where('id_perusahaan', '=', $perusahaan->id);
            $models = $query->get();

            return Helper::responseSuccess([
                'akuns' => $models,
            ]);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    public function new($id)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $model = Akun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            // nomor terakhir
            $nextLevel = $model->level + 1;
            $latNo = Akun::where([
                ['id_perusahaan', '=', $perusahaan->id],
                ['level', '=', $nextLevel],
                ['no', 'like', $model->no.'%'],
            ])->orderBy('no', 'DESC')->first();

            // konsep akun
            $konsepAkun = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id)->first();
            $konsepAkunDetail = $konsepAkun == null ? null :KonsepAkunDetail::where([
                ['id_konsep_akun', '=', $konsepAkun['id']],
                ['level', '=', $nextLevel],
            ])->first();

            return Helper::responseSuccess([
                'akun' => $model,
                'child' => $latNo,
                'konsepAkun' => $konsepAkunDetail,
            ]);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }
}
