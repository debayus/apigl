<?php

namespace App\Models;

class Helper
{
    public static function responseErrorNotFound() {
        return Helper::responseError('Data tidak ditemukan');
    }

    public static function responseErrorNoPerusahaan() {
        return Helper::responseError('Perusahaan tidak ditemukan');
    }

    public static function responseErrorNoUser() {
        return Helper::responseError('User tidak ditemukan');
    }

    public static function responseError($message) {
        return response()->json([
            'message' => $message,
        ], 501);
    }

    public static function responseList($data, $totalRowCount) {
        return response()->json([
            'data' => $data,
            'totalRowCount' => $totalRowCount
        ]);
    }

    public static function responseSuccess($data = null) {
        return response()->json($data);
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function findObjectById($array, $id, $key = 'id'){
        foreach ($array as $element) {
            if ($id == $element[$key]) {
                return $element;
            }
        }
        return null;
    }

    public static function findObject($array, $params){
        foreach ($array as $element) {
            $g = true;
            foreach (array_keys($params) as $key){
                if ($g){
                    if ($params[$key] != $element[$key]){
                        $g = false;
                    }
                }
            }
            if ($g) {
                return $element;
            }
        }
        return null;
    }

}
