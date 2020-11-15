<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Peminjaman;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function get_users(){
        $data = ['user' => User::all()];
        return response()->json($data, 200);
    }
    public function get_a_user($id){
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
            $id_now = User::get()->where('id',$id);
            if($id_now->count() > 0){
                $data = ['user' => $id_now];
                return response()->json($data, 200);
            } else {
                $error = ['error' => 'Cannot found data with id = '.$id];
                return response()->json($error, 400);
            }
        }
    }

    public function post_a_user(Request $req){
        $validatedData = Validator::make($req->all(), [
            'nama_lengkap' => 'required|max:50',
            'nama_panggilan' => 'required|max:50',
            'alamat' => 'required|max:225',
            'email' => 'required|unique:users,email',
        ]);

        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $user = new User();
            $user->nama_lengkap = $req->nama_lengkap;
            $user->nama_panggilan = $req->nama_panggilan;
            $user->alamat = $req->alamat;
            $user->email = $req->email;
            if($user->save()){
                return response()->json([
                    'message' => 'data saved successfully!',
                    'data' => $user
                ], 201);
            }
        }
    }
    public function update_a_user(Request $req, $id){
        $id_now = User::find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with id = '.$id], 400);
        }

        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ], $req->all()),
            [
                'id' => 'required|integer',
                'nama_lengkap' => 'required|max:50',
                'nama_panggilan' => 'required|max:50',
                'alamat' => 'required|max:225',
                'email' => 'required|email|unique:users',
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),400);
        }else{
            $user = $id_now;
            $user->nama_lengkap = $req->nama_lengkap;
            $user->nama_panggilan = $req->nama_panggilan;
            $user->alamat = $req->alamat;
            $user->email = $req->email;
            if($user->update()){
                return response()->json([
                    'message' => 'data updated successfully!',
                    'data' => $user
                ], 200);
            }
        }
    }
    public function delete_a_user($id){
        $id_now = User::find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with id = '.$id], 400);
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
            $peminjaman = Peminjaman::where('deleted_at', null)->firstWhere('id_book',$id);
            if($peminjaman){
                return response()->json(['error' => 'pengguna dengan id = '.$id.' tidak bisa dihapus karena sedang meminjam buku'], 400);
            }
            $user = $id_now;
            if($user->delete()){
                return response()->json([
                    'message' => 'data deleted successfully!',
                ], 200);
            }
        }
    }
}
