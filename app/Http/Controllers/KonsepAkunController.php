<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\KonsepAkun;
use App\Models\KonsepAkunDetail;
use App\Models\Perusahaan;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonsepAkunController extends Controller
{
    public function index(Request $request)
    {
        try{
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $query = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id);
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

            $model = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = KonsepAkunDetail::where('id_konsep_akun', '=', $model->id)->get();
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
            $model = new KonsepAkun;
            $model->id_perusahaan = $perusahaan->id;
            $model->levelmax = $request->levelmax;
            $model->digitmax = $request->digitmax;
            $model->save();

            // insert
            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $detail = new KonsepAkunDetail;
                $detail->id_konsep_akun = $model->id;
                $detail->level = $item['level'];
                $detail->jumlahdigit = $item['jumlahdigit'];
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

            $model = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = KonsepAkunDetail::where('id_konsep_akun', '=', $model->id)->get();

            DB::beginTransaction();

            $model->levelmax = $request->levelmax;
            $model->digitmax = $request->digitmax;
            $model->save();

            // delete detail
            for ($i = 0; $i < count($detail); $i++) {
                $has = Helper::findObjectById($request->detail, $detail[$i]->level, 'level');
                if (!$has){
                    KonsepAkunDetail::where([
                        ['id_konsep_akun', '=', $model->id],
                        ['level', '=', $detail[$i]->level]
                    ])->delete();
                }
            }

            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $has = Helper::findObjectById($detail, $item['level'], 'level');

                if (!$has){

                    // add detail
                    $DbItem = new KonsepAkunDetail;
                    $DbItem->id_konsep_akun = $model->id;
                    $DbItem->level = $item['level'];
                    $DbItem->jumlahdigit = $item['jumlahdigit'];
                    $DbItem->save();

                }else{

                    // update detail
                    DB::table('konsep_akun_details')->where([
                        ['id_konsep_akun', '=', $model->id],
                        ['level', '=', $has->level]
                    ])->limit(1)->update([
                        'jumlahdigit' => $item['jumlahdigit']
                    ]);
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

            $model = KonsepAkun::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = KonsepAkunDetail::where('id_konsep_akun', '=', $model->id);

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
