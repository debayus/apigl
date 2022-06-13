<?php

namespace App\Http\Controllers;

use App\Models\Helper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try{
            $userId = auth()->user()->id;
            $user = User::find($userId);
            return response()->json($user);
        } catch (Exception $ex){
            return Helper::responseError($ex->getMessage());
        }
    }
}
