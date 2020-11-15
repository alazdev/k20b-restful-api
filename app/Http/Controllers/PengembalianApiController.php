<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use App\Peminjaman;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PengembalianApiController extends Controller
{
    public function get_pengembalians(){
        $data = ['pengembalian' => Peminjaman::select('id','id_user','id_book','total_denda','deleted_at AS created_at')->where('deleted_at', '!=', null)->get()];
        return response()->json($data, 200);
    }
    public function get_a_pengembalian($id){
        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ]),
            [
                'id' => 'required|integer'
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        } else {
            $id_now = Peminjaman::select('id','id_user','id_book','total_denda','deleted_at AS created_at')->where('deleted_at', '!=', null)->where('id',$id)->get();
            if($id_now->count() > 0){
                $data = ['pengembalian' => $id_now];
                return response()->json($data, 200);
            } else {
                $error = ['error' => 'Cannot found data with ID = '.$id];
                return response()->json($error, 400);
            }
        }
    }
    public function update_a_pengembalian(Request $req, $id){
        $id_now = Peminjaman::where('deleted_at', null)->find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with ID peminjaman = '.$id], 400);
        }

        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ], $req->all()),
            [
                'id' => 'required|integer',
                'total_denda' => 'required|integer',
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $pengembalian = Peminjaman::select('id','id_user','id_book','total_denda','deleted_at')->get(['peminjamen.deleted_at AS created_at'])->where('id',$id)->first();
            $pengembalian->total_denda = $req->total_denda;
            $pengembalian->deleted_at = Carbon::now();
            if($pengembalian->update()){
                return response()->json([
                    'message' => 'data updated successfully!',
                    'data' => $pengembalian
                ], 200);
            }
        }
    }
}
