<?php

namespace App\Database\Seeds;

use App\Models\KamarModel;
use CodeIgniter\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run()
    {
        $r =(int)(new KamarModel())->insert([
            'kamartipe_id' => 1,
            'lantai' => '15',
            'nomor' => '401',
            'kamarstatus_id' => 1,
            'deskripsi' => 'kamar sudah dipersiapakan',
        ]);
        echo "hasil insert $r";
    }
}