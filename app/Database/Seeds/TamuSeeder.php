<?php

namespace App\Database\Seeds;

use App\Models\TamuModel;
use CodeIgniter\Database\Seeder;

class TamuSeeder extends Seeder
{
    public function run()
    {
        $r = (int)(new TamuModel())->insert([
            'nama_depan' => 'Ahmad',
            'nama_belakang' => 'Hidayat',
            'gender' => 'L',
            'alamat' => 'jl.rubini',
            'kota' => 'Singkawang',
            'negara_id' => 1,
            'nohp' => '08456789012',
            'email' => 'user@gmail.com',
            'sandi' => password_hash('user', PASSWORD_BCRYPT),
            'token_reset' => '123456',
        ]);
        
        echo "hasil insert $r";
    }
}