<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaUserToRiwayat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('riwayat_diagnosa', [
            'nama_user' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'id_user',
            ]
        ]);

        $this->forge->modifyColumn('riwayat_diagnosa', [
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('riwayat_diagnosa', 'nama_user');
        // We probably shouldn't revert the nullability of id_user to avoid errors on down, or we could if we wanted.
    }
}
