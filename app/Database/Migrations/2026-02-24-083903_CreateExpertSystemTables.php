<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExpertSystemTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penyakit' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'nama_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'solusi' => [
                'type' => 'TEXT',
            ],
            'gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_penyakit', true);
        $this->forge->createTable('penyakit');

        $this->forge->addField([
            'id_gejala' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_gejala' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
            ],
            'nama_gejala' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id_gejala', true);
        $this->forge->createTable('gejala');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penyakit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_gejala' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'cf' => [
                'type'       => 'FLOAT',
                'constraint' => '3,2',
                'default'    => 0.5,
            ],
            'mb' => [
                'type'       => 'FLOAT',
                'constraint' => '3,2',
                'default'    => 0,
            ],
            'md' => [
                'type'       => 'FLOAT',
                'constraint' => '3,2',
                'default'    => 0,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penyakit', 'penyakit', 'id_penyakit', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_gejala', 'gejala', 'id_gejala', 'CASCADE', 'CASCADE');
        $this->forge->createTable('basis_pengetahuan');
    }

    public function down()
    {
        $this->forge->dropTable('basis_pengetahuan', true);
        $this->forge->dropTable('gejala', true);
        $this->forge->dropTable('penyakit', true);
    }
}
