<?php

namespace App\Database\Seeds;

use App\Models\PemesananModel;
use CodeIgniter\Database\Seeder;

class PemesananSeeder extends Seeder
{
    public function run()
    {
        $r =(int)(new PemesananModel())->insert([
            'kamar_id' => 1,
            'tgl_mulai' => '2022-10-17',
            'tgl_selesai' => '2022-10-20',
            'pemesananstatus_id' => 0,
            'tamu_id' => 0,
        ]);
        
        echo "hasil insert $r";
    }
}