<?php

namespace App\Http\Controllers;

use App\Models\StrukturAkun;
use Illuminate\Http\Request;

class StrukturAkunController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $models = StrukturAkun::where('id_user', '=', $userId)->simplePaginate(15);
        return response()->json($models);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $model = new StrukturAkun;
        $model->id_user = $userId;
        $model->nama = $request->nama;
        $model->save();
        return response()->json([
            "message" => "Added."
        ], 201);
    }

    public function show($id)
    {
        $userId = auth()->user()->id;

        $model = StrukturAkun::where('id_user', '=', $userId)->find($id);
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

        $model = StrukturAkun::where('id_user', '=', $userId)->find($id);
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

        $model = StrukturAkun::where('id_user', '=', $userId)->find($id);
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
