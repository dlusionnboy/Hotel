<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kamarstatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type'=>'int', 'constraint'=>10, 'unsigned'=>true, 'auto_increment'=>true],
            'status'        => ['type'=>'varchar', 'constraint'=>100, 'null'=>true],
            'keterangan'    => ['type'=>'text', 'null'=>true],
            'urutan'        => ['type'=>'int', 'null'=>true],
            'aktif'         => ['type'=>'enum("Y", "T")', 'null'=>true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kamartarif');
    }

    public function down()
    {
        $this->forge->droptable('kamartarif');
    }
}
