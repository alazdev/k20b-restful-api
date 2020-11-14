<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengembalian;

class PengembalianApiController extends Controller
{
    public function get_pengembalians(){
        $data = ['pengembalian' => Pengembalian::all()];
        return response()->json($data, 200);
    }
    public function get_a_pengembalian($id){
        $id_now = Pengembalian::get()->where('id',$id);
        if($id_now->count() > 0){
            $data = ['pengembalian' => $id_now];
            return response()->json($data, 200);
        } else {
            $error = ['error' => 'Cannot found data with id = '.$id];
            return response()->json($error, 200);
        }
    }
}
