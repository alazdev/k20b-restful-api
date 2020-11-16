<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman;
use App\User;
use App\Book;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PeminjamanApiController extends Controller
{
    public function get_peminjamans(){
        $data = ['peminjaman' => Peminjaman::where('deleted_at', null)->select('id','id_user','id_book','created_at')->get()];
        return response()->json($data, 200);
    }
    public function get_a_peminjaman($id){
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
            $id_now = Peminjaman::select('id','id_user','id_book','created_at')->get()->where('deleted_at', null)->where('id',$id);
            if($id_now->count() > 0){
                $data = ['peminjaman' => $id_now];
                return response()->json($data, 200);
            } else {
                $error = ['error' => 'Cannot found data with ID = '.$id];
                return response()->json($error, 400);
            }
        }
    }
    public function post_a_peminjaman(Request $req){
        $validatedData = Validator::make($req->all(), [
            'id_book' => 'required|integer',
            'id_user' => 'required|integer',
        ]);

        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $check_user = User::find($req->id_user);
            $check_book = Book::find($req->id_book);
            if($check_user && $check_book){
                $data_user = Peminjaman::where('deleted_at', null)->firstWhere('id_user', $req->id_user);
                $data_book = Peminjaman::where('deleted_at', null)->firstWhere('id_book', $req->id_book);
                if($data_user){
                    return response()->json(['error' => 'Setiap user hanya bisa meminjam 1 buku'], 400);
                }
                if($data_book){
                    return response()->json(['error' => 'Buku ini sedang dipinjam user lain'], 400);
                }
                $peminjaman = new Peminjaman();
                $peminjaman->id_user = $req->id_user;
                $peminjaman->id_book = $req->id_book;
                if($peminjaman->save()){
                    return response()->json([
                        'message' => 'data saved successfully!',
                        'data' => $peminjaman
                    ], 201);
                }
            }else{
                return response()->json(['error' => 'ID user atau ID buku tidak ditemukan'], 400);
            }
        }
    }
    public function delete_a_peminjaman($id){
        $id_now = Peminjaman::where('deleted_at', null)->find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with ID peminjaman = '.$id], 400);
        }

        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ]),
            [
                'id' => 'required|integer',
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $pengembalian = $id_now;
            if($pengembalian->delete()){
                return response()->json([
                    'message' => 'data deleted successfully!',
                ], 200);
            }
        }
    }
}
