<?php

namespace App\Database\Seeds;

use App\Models\KamarDipesanModel;
use CodeIgniter\Database\Seeder;

class KamarDipesanSeeder extends Seeder
{
    public function run()
    {
        $r = (int)(new KamarDipesanModel())->insert([
            'pemesanan_id' => 0,
            'kamar_id' => 1,
            'tarif' => '1000000',
            'pengguna_id' => 1,
        ]);
        echo "hasil insert $r";
    }
}