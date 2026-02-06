<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerangkatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'nama'=>[
                'type'=>'VARCHAR',
                'constraint'=>100,
            ],
            'noreg'=>[
                'type'=>'VARCHAR',
                'constraint'=>50,
            ],
            'serial_number'=>[
                'type'=>'VARCHAR',
                'constraint'=>50,
            ],
            'status'=>[
                'type'=>'ENUM',
                'constraint'=>['Tersedia', 'Tidak Tersedia'],
                'default'=>'tersedia',
            ],
            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>false,
            ],
            'updated_at'=>[
                'type'=>'DATETIME',
                'null'=>true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('noreg','serial_number');
        $this->forge->createTable('perangkat');
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
