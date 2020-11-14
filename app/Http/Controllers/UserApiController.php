<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserApiController extends Controller
{
    public function get_users(){
        $data = ['user' => User::all()];
        return response()->json($data, 200);
    }
    public function get_a_user($id){
        $id_now = User::get()->where('id',$id);
        if($id_now->count() > 0){
            $data = ['user' => $id_now];
            return response()->json($data, 200);
        } else {
            $error = ['error' => 'Cannot found data with id = '.$id];
            return response()->json($error, 200);
        }
    }
}
