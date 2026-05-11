<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatDiagnosaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_riwayat' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_penyakit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nama_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kode_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'gejala_dipilih' => [
                'type' => 'TEXT',
            ],
            'detail_gejala' => [
                'type' => 'TEXT',
            ],
            'cf_hasil' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,4',
            ],
            'persentase' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
            'solusi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_diagnosa' => [
                'type' => 'DATETIME',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_riwayat', true);
        $this->forge->createTable('riwayat_diagnosa');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_diagnosa');
    }
}