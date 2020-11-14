<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Peminjaman;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    public function get_books(){
        $data = ['book' => Book::all()];
        return response()->json($data, 200);
    }
    public function get_a_book($id){
        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ]),
            [
                'id' => 'required|integer'
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),200);
        } else {
            $id_now = Book::get()->where('id',$id);
            if($id_now->count() > 0){
                $data = ['book' => $id_now];
                return response()->json($data, 200);
            } else {
                $error = ['error' => 'Cannot found data with id = '.$id];
                return response()->json($error, 200);
            }
        }
    }

    public function post_a_book(Request $req){
        $validatedData = Validator::make($req->all(), [
            'judul_buku' => 'required|max:50',
            'jumlah_halaman' => 'required|max:9999|integer',
            'tahun_terbit' => 'required|max:9999|integer',
        ]);

        if($validatedData->fails()){
            return response()->json($validatedData->errors(),200);
        }else{
            $book = new Book();
            $book->judul_buku = $req->judul_buku;
            $book->jumlah_halaman = $req->jumlah_halaman;
            $book->tahun_terbit = $req->tahun_terbit;
            if($book->save()){
                return response()->json([
                    'message' => 'data saved successfully!',
                    'data' => $book
                ], 201);
            }
        }
    }
    public function update_a_book(Request $req, $id){
        $id_now = Book::find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with id = '.$id], 200);
        }

        $validatedData = Validator::make(array_merge(
            [
                'id' => $id
            ], $req->all()),
            [
                'id' => 'required|integer',
                'judul_buku' => 'required|max:50',
                'jumlah_halaman' => 'required|max:9999|integer',
                'tahun_terbit' => 'required|max:9999|integer',
            ]
        );
        if($validatedData->fails()){
            return response()->json($validatedData->errors(),200);
        }else{
            $book = $id_now;
            $book->judul_buku = $req->judul_buku;
            $book->jumlah_halaman = $req->jumlah_halaman;
            $book->tahun_terbit = $req->tahun_terbit;
            if($book->update()){
                return response()->json([
                    'message' => 'data updated successfully!',
                    'data' => $book
                ], 201);
            }
        }
    }
    public function delete_a_book($id){
        $id_now = Book::find($id);
        if(!$id_now){
            return response()->json(['error' => 'Cannot found data with id = '.$id], 200);
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
            return response()->json($validatedData->errors(),200);
        }else{
            $peminjaman = Peminjaman::firstWhere('id_book',$id);
            if($peminjaman){
                return response()->json(['error' => 'buku dengan id = '.$id.' tidak bisa dihapus karena sedang dipinjam'], 200);
            }
            $book = $id_now;
            if($book->delete()){
                return response()->json([
                    'message' => 'data deleted successfully!',
                ], 200);
            }
        }
    }
}
