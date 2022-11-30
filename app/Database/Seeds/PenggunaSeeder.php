<?php

namespace App\Database\Seeds;

use App\Database\Migrations\Pengguna;
use App\Models\PenggunaModel;
use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $id = (new PenggunaModel())->insert([
            'nama_depan' => 'Ilham',
            'nama_belakang' => 'Naffi',
            'gender' => 'L',
            'alamat' => 'Jl. kuhancurkarnadia',
            'kota' => 'Pontianak',
            'tgl_lhr' => '2000-05-15',
            'notelp' => '0566175',
            'nohp' => '08436785013',
            'email' => 'admin@gmail.com',
            'level' => 'M',
            'sandi' => password_hash('admin', PASSWORD_BCRYPT),
            'token_reset' => '123456',
        ]);
        echo "hasil id = $id";
        
    }
}