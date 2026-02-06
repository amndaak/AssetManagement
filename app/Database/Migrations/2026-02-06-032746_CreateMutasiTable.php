<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMutasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'id_perangkat'=>[
                'type'=>'INT',
                'unsigned'=>true,
            ],
            'user'=>[
                'type'=>'ENUM',
                'constraint'=>['Sandi','Faizin','Aryo','Andre','Anang','Fahri','Iqbal','Nawal','Adit','Giri','Albaskoro'],
                'null'=>true,
            ],
            'status'=>[
                'type'=>'ENUM',
                'constraint'=>['Dibawa', 'Terpasang','Kembali'],
                'null'=>true,
            ],
            'keterangan'=>[
                'type'=>'TEXT',
                'null'=>true,
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
        $this->forge->addForeignKey('id_perangkat','perangkat','id','CASCADE','CASCADE');
        $this->forge->createTable('mutasi');
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
