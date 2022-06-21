<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurnal;
use App\Models\Helper;
use App\Models\JurnalDetail;
use App\Models\Perusahaan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }
            $perusahaan = Perusahaan::find($user->id_perusahaan);
            if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

            $query = Jurnal::where('id_perusahaan', '=', $perusahaan->id);
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

            $model = Jurnal::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();

            $detail = JurnalDetail::where('id_jurnal', '=', $model->id)->get();
            $model['detail'] = $detail;

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

            // get akun
            $akunsId = [];
            foreach ($request->detail as $element) {
                array_push($akunsId, $element['id_akun']);
            }
            $akuns = Akun::where('id_perusahaan', '=', $perusahaan->id)->wherein('id', $akunsId)->get();

            // auto no jurnal
            $kodeTgl = 'yyMMdd'; // belum
            $kode = $kodeTgl.'JUR-';
            $lastJurnal = Jurnal::where([
                ['id_perusahaan', '=', $perusahaan->id],
                ['no', 'like', $kode.'%']
            ])->orderBy('no', 'DESC')->first();
            $kodeNum = $lastJurnal == null ? 0 : (int)str_replace($kode, '', $lastJurnal->no);
            $kodeNum += 1;
            $no = $kode.Helper::AddChar($kodeNum, 3, '0');

            DB::beginTransaction();
            $model = new Jurnal;
            $model->id_perusahaan = $perusahaan->id;
            $model->id_user_create = $userId;
            $model->id_user_update = null;
            $model->id_user_tutupbuku = null;
            $model->id_user_batal = null;
            $model->no = $no;
            $model->tanggal = $request->tanggal;
            $model->catatan = $request->catatan;
            $model->id_proyek = $request->id_proyek;
            $model->debit = $request->debit;
            $model->kredit = $request->kredit;
            $model->tutupbuku = false;
            $model->batal = false;
            $model->batalketerangan = null;
            $model->id_tutupbuku = null;
            $model->save();

            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $akun = Helper::findObjectById($akuns, $item['id_akun'], 'id');
                if (empty($akun)) throw new Exception('akun tidak ditemukan');

                $detail = new JurnalDetail;
                $detail->id_jurnal = $model->id;
                $detail->id_akun = $item['id_akun'];
                $detail->debit = $item['debit'];
                $detail->kredit = $item['kredit'];
                $detail->catatan = $item['catatan'];
                $detail->komponen = $akun['komponen'];
                $detail->id_jurnal = $akun['id_jurnal'];
                $detail->id_jurnal_detail = $akun['id_jurnal_detail'];
                $detail->normalpos = $akun['normalpos'];
                $detail->level = $akun['level'];
                $detail->no = $akun['no'];
                $detail->nama = $akun['nama'];
                $detail->save();
            }
            DB::commit();
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            DB::rollback();
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

            $model = Jurnal::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();
            $detail = JurnalDetail::where('id_jurnal', '=', $model->id)->get();

            // get akun
            $akunsId = [];
            foreach ($request->detail as $element) {
                array_push($akunsId, $element['id_akun']);
            }
            $akuns = Akun::where('id_perusahaan', '=', $perusahaan->id)->wherein('id', $akunsId)->get();

            DB::beginTransaction();
            $model->id_user_update = $userId;
            $model->tanggal = $request->tanggal;
            $model->catatan = $request->catatan;
            $model->debit = $request->debit;
            $model->kredit = $request->kredit;
            $model->save();

            // delete detail
            for ($i = 0; $i < count($detail); $i++) {
                $has = Helper::findObjectById($request->detail, $detail[$i]->id_akun, 'id_akun');
                if (!$has){
                    JurnalDetail::where('id_jurnal', '=', $model->id)->find($detail[$i]->id_akun)->delete();
                }
            }

            for ($i = 0; $i < count($request->detail); $i++) {
                $item = $request->detail[$i];
                $has = Helper::findObjectById($detail, $item['id']);
                $akun = Helper::findObjectById($akuns, $item['id_akun'], 'id');
                if (empty($akun)) throw new Exception('akun tidak ditemukan');

                if (!$has){

                    // add detail
                    $DbItem = new JurnalDetail;
                    $DbItem->id_jurnal = $model->id;
                    $DbItem->id_akun = $item['id_akun'];
                    $DbItem->debit = $item['debit'];
                    $DbItem->kredit = $item['kredit'];
                    $DbItem->catatan = $item['catatan'];
                    $DbItem->komponen = $akun['komponen'];
                    $DbItem->id_jurnal = $akun['id_jurnal'];
                    $DbItem->id_jurnal_detail = $akun['id_jurnal_detail'];
                    $DbItem->normalpos = $akun['normalpos'];
                    $DbItem->level = $akun['level'];
                    $DbItem->no = $akun['no'];
                    $DbItem->nama = $akun['nama'];
                    $DbItem->save();

                }else{

                    // update detail
                    DB::table('jurnal_details')->where([
                        ['id_jurnal', '=', $model->id],
                        ['id_akun', '=', $has->id_akun]
                    ])->limit(1)->update([
                        'debit' => $item['debit'],
                        'kredit' => $item['kredit'],
                        'catatan' => $item['catatan'],
                        'komponen' => $akun['komponen'],
                        'id_jurnal' => $akun['id_jurnal'],
                        'id_jurnal_detail' => $akun['id_jurnal_detail'],
                        'normalpos' => $akun['normalpos'],
                        'level' => $akun['level'],
                        'no' => $akun['no'],
                        'nama' => $akun['nama'],
                    ]);

                }
            }


            DB::commit();
            return Helper::responseSuccess($model);
        } catch (Exception $ex){
            DB::rollback();
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

            $model = Jurnal::where('id_perusahaan', '=', $perusahaan->id)->find($id);
            if (empty($model)) return Helper::responseErrorNotFound();
            $detail = JurnalDetail::where('id_jurnal', '=', $model->id);

            $detail->delete();
            $model->delete();

            return Helper::responseSuccess();
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }

    // public function master(Request $request)
    // {
    //     try {
    //         $userId = auth()->user()->id;
    //         $user = User::find($userId);
    //         if (empty($user)) { return Helper::responseErrorNoUser(); }
    //         $perusahaan = Perusahaan::find($user->id_perusahaan);
    //         if (empty($perusahaan)) return Helper::responseErrorNoPerusahaan();

    //         // struktur Jurnal
    //         $strukturJurnal = StrukturJurnal::where('id_perusahaan', '=', $perusahaan->id)->get();

    //         // struktur Jurnal detail
    //         $strukturJurnalId = [];
    //         foreach ($strukturJurnal as $element) {
    //             array_push($strukturJurnalId, $element['id']);
    //         }
    //         $strukturJurnalDetail = StrukturJurnalDetail::whereIn('id_struktur_Jurnal', $strukturJurnalId)->get();

    //         // konsep Jurnal
    //         $konsepJurnal = KonsepJurnal::where('id_perusahaan', '=', $perusahaan->id)->first();

    //         // konsep Jurnal detail
    //         $konsepJurnalDetail = $konsepJurnal == null ? [] :KonsepJurnalDetail::where('id_konsep_Jurnal', '=', $konsepJurnal['id'])->get();

    //         return Helper::responseSuccess([
    //             'strukturJurnal' => $strukturJurnal,
    //             'strukturJurnalDetail' => $strukturJurnalDetail,
    //             'konsepJurnalDetail' => $konsepJurnalDetail,
    //         ]);
    //     } catch (Exception $ex){
    //         return Helper::responseError($ex->getMessage());
    //     }
    // }
}
