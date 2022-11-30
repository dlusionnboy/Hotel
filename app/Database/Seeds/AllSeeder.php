<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
    public function run()
    {
        $this->call('penggunaseeder');
        $this->call('metodebayarseeder');
        $this->call('tipetarifseeder');
        $this->call('kamartipeseeder');
        $this->call('kamartarifseeder');
        $this->call('kamarstatusseeder');
        $this->call('kamarseeder');
        $this->call('pemesananstatusseeder');
        $this->call('negaraseeder');
        $this->call('tamuseeder');
        $this->call('pemesananseeder');
        $this->call('kamardipesanseeder');
        $this->call('pembayaranseeder');
    }
}