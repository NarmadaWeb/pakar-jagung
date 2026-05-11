<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProtokolToPenyakit extends Migration
{
    public function up()
    {
        $this->forge->addColumn('penyakit', [
            'tindakan_segera' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'protokol_pengobatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'strategi_pencegahan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('penyakit', ['tindakan_segera', 'protokol_pengobatan', 'strategi_pencegahan']);
    }
}
