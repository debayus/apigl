<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Helper;
use App\Models\KonsepAkun;
use App\Models\KonsepAkunDetail;
use App\Models\Perusahaan;
use App\Models\Proyek;
use App\Models\SetupAwal;
use App\Models\StrukturAkun;
use App\Models\StrukturAkunDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerusahaanController extends Controller
{
    public function store(Request $request)
    {
        try {
            $userId = auth()->user()->id;
            $user = User::find($userId);
            if (empty($user)) { return Helper::responseErrorNoUser(); }

            // check user
            if (!is_null($user->id_perusahaan)) { return Helper::responseError('User sudah terdaftar'); }

            DB::beginTransaction();

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

            // proyek
            $proyek = new Proyek;
            $proyek->id_perusahaan = $model->id;
            $proyek->nama = $request->nama;
            $proyek->save();

            // struktur akun
            $strukturAkuns = [];
            $strukturAkunDetails = [];
            for($i = 0; $i < count(SetupAwal::$struktur_akun); $i++){
                $x = SetupAwal::$struktur_akun[$i];
                $strukturAkun = new StrukturAkun;
                $strukturAkun->id_perusahaan = $model->id;
                $strukturAkun->nama = $x['nama'];
                $strukturAkun->jenis = $x['jenis'];
                $strukturAkun->save();

                for ($j = 0; $j < count($x['detail']); $j++) {
                    $y = $x['detail'][$j];
                    $strukturAkunDetail = new StrukturAkunDetail;
                    $strukturAkunDetail->id_struktur_akun = $strukturAkun->id;
                    $strukturAkunDetail->nama = $y['nama'];
                    $strukturAkunDetail->cash = $y['cash'];
                    $strukturAkunDetail->bank = $y['bank'];
                    $strukturAkunDetail->save();
                    array_push($strukturAkunDetails, $strukturAkunDetail);
                }
                array_push($strukturAkuns, $strukturAkun);
            }

            // konsep akun
            $konsepAkun = new KonsepAkun;
            $konsepAkun->id_perusahaan = $model->id;
            $konsepAkun->levelmax = SetupAwal::$konsep_akun['levelmax'];
            $konsepAkun->digitmax = SetupAwal::$konsep_akun['digitmax'];
            $konsepAkun->save();
            for ($i = 0; $i < count(SetupAwal::$konsep_akun['detail']); $i++) {
                $y = SetupAwal::$konsep_akun['detail'][$i];
                $konsepAkunDetail = new KonsepAkunDetail;
                $konsepAkunDetail->id_konsep_akun = $konsepAkun->id;
                $konsepAkunDetail->level = $y['level'];
                $konsepAkunDetail->jumlahdigit = $y['jumlahdigit'];
                $konsepAkunDetail->save();
            }

            // akun
            for($i = 0; $i < count(SetupAwal::$akun); $i++){
                $x = SetupAwal::$akun[$i];
                $strukturAkun = Helper::findObjectById($strukturAkuns, $x['id_struktur_akun'], 'nama');
                if ($strukturAkun == null){
                    throw new Exception($x['id_struktur_akun'].' tidak ditemukan');
                }
                $strukturAkunDetail = Helper::findObject($strukturAkunDetails,[
                    'id_struktur_akun' => $strukturAkun->id,
                    'nama' => $x['id_struktur_akun_detail']
                ]);
                if ($x['id_struktur_akun_detail'] != null && $strukturAkunDetail == null){
                    throw new Exception($x['id_struktur_akun_detail'].' tidak ditemukan');
                }
                $akun = new Akun;
                $akun->id_perusahaan = $model->id;
                $akun->komponen = $x['komponen'];
                $akun->id_struktur_akun = $strukturAkun == null ? null : $strukturAkun['id'];
                $akun->id_struktur_akun_detail = $strukturAkunDetail == null ? null : $strukturAkunDetail['id'];
                $akun->normalpos = $x['normalpos'];
                $akun->level = $x['level'];
                $akun->no = $x['no'];
                $akun->nama = $x['nama'];
                $akun->save();
            }

            // laba rugi akun


            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return Helper::responseError($ex->getMessage());
        }

        return Helper::responseSuccess();
    }
}
