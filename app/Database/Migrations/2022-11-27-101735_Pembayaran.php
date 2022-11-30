<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true ],
            'tgl'               => ['type'=>'datetime', 'null'=>true ],
            'tagihan'           => ['type'=>'double', 'null'=>true ],
            'dibayar'           => ['type'=>'double', 'null'=>true ],
            'nama_pembayar'     => ['type'=>'varchar', 'constraint'=>50, 'null'=>true],
            'metodebayar_id'    => ['type'=>'int', 'constraint'=>10, 'null'=>true, 'unsigned'=>true, ],
            'pengguna_id'       => ['type'=>'int', 'constraint'=>10, 'null'=>true, 'unsigned'=>true, ],
            'created_at'        => ['type'=>'datetime', 'null'=>true ],
            'updated_at'        => ['type'=>'datetime', 'null'=>true ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id', 'kamarDipesan', 'id', 'cascade', 'restrict');
        $this->forge->addForeignKey('metodebayar_id', 'metodebayar', 'id', 'cascade', 'set null');
        $this->forge->addForeignKey('pengguna_id', 'pengguna', 'cascade', 'set null');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
    
}
