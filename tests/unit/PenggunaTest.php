<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
class PenggunaTest extends CIUnitTestCase{

    use FeatureTestTrait;

    public function testLogin(){
        $this->call('post', 'login', [
            'email' => 'naffiilham@gmail.com',
            'sandi' => '123456'
        ])->assertStatus(404);
    }
    
    public function testCreateShowUpdateDelete(){
        $json = $this->call('post', 'pengguna', [
            'nama_depan' => 'Ilham',
            'nama_belakang' => 'Naffi',
            'gender' => 'L',
            'alamat' => 'Jl. kuhancurkarnadia',
            'kota' => 'Pontianak',
            'tgl_lhr' => '2000-05-15',
            'notelp' => '0566175',
            'nohp' => '08436785013',
            'email' => 'admin@gmail.com',
            'level' => 'R',
            'sandi' => password_hash('admin', PASSWORD_BCRYPT),
            'token_reset' => '123456',
        ])->getJSON();
        $js = json_decode($json, true);

        $this->assertTrue($js['id'] > 0);

        $this->call('get', "pengguna/".$js['id'])
            ->assertStatus(200);
        
        $this->call('patch', 'pengguna', [
            'nama_depan' => 'Ilham',
            'nama_belakang' => 'Naffi',
            'gender' => 'L',
            'alamat' => 'Jl. kuhancurkarnadia',
            'kota' => 'Pontianak',
            'tgl_lhr' => '2000-05-15',
            'notelp' => '0566175',
            'nohp' => '08436785013',
            'email' => 'adminupdate@gmail.com',
            'level' => 'R',
            'id' => $js['id']
        ])->assertStatus(200);

        $this->call('delete', 'pengguna', [
            'id' => $js['id']
        ])->assertStatus(200);
    }


    public function testRead(){
        $this->call('get', 'pengguna/all')
             ->assertStatus(200);
    }

    public function testLogout(){
        $this->call('delete', 'login')
             ->assertStatus(302);
    }
}