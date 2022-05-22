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
            'success' => false,
            'message' => $message,
        ]);
    }

    public static function responseSuccess($data = null) {
        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
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

}
