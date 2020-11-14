<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman;

class PeminjamanApiController extends Controller
{
    public function get_peminjamans(){
        $data = ['peminjaman' => Peminjaman::all()];
        return response()->json($data, 200);
    }
    public function get_a_peminjaman($id){
        $id_now = Peminjaman::get()->where('id',$id);
        if($id_now->count() > 0){
            $data = ['peminjaman' => $id_now];
            return response()->json($data, 200);
        } else {
            $error = ['error' => 'Cannot found data with id = '.$id];
            return response()->json($error, 200);
        }
    }
}
