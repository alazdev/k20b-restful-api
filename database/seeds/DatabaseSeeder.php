<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            [
                'id' => 1,
                'judul_buku' => Str::random(10),
                'jumlah_halaman' => '150',
                'tahun_terbit' => '2020',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'judul_buku' => Str::random(10),
                'jumlah_halaman' => '159',
                'tahun_terbit' => '2002',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'judul_buku' => Str::random(10),
                'jumlah_halaman' => '91',
                'tahun_terbit' => '2018',
                'created_at' => Carbon::now(),
            ]
        ]);
        DB::table('users')->insert([
            [
                'nama_lengkap' => 'Al Azim',
                'nama_panggilan' => 'Azim',
                'alamat' => Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_lengkap' => Str::random(10),
                'nama_panggilan' => Str::random(8),
                'alamat' => Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_lengkap' => Str::random(10),
                'nama_panggilan' => Str::random(8),
                'alamat' => Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_lengkap' => Str::random(10),
                'nama_panggilan' => Str::random(8),
                'alamat' => Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'created_at' => Carbon::now(),
            ],
            [
                'nama_lengkap' => Str::random(10),
                'nama_panggilan' => Str::random(8),
                'alamat' => Str::random(30),
                'email' => Str::random(10).'@gmail.com',
                'created_at' => Carbon::now(),
            ]
        ]);
        DB::table('peminjamen')->insert(
            [
                'id' => 1,
                'id_user' => 1,
                'id_book' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 1,
                'id_user' => 5,
                'id_book' => 3,
                'created_at' => Carbon::now(),
            ]
        );
    }
}
