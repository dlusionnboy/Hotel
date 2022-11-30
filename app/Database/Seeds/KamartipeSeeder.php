<?php

namespace App\Database\Seeds;

use App\Models\KamartipeModel;
use CodeIgniter\Database\Seeder;

class KamartipeSeeder extends Seeder
{
    public function run()
    {
        $id = (new KamartipeModel())->insert([
            'tipe' => 'deluxe',
            'keterangan' => 'besar',
            'urutan' => '1',
            'aktif' => 'Y',
            'gambar' => '',
        ]);
        echo "hasil id = $id";
    }
}