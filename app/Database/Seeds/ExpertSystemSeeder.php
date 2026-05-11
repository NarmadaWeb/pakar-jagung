<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ExpertSystemSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $db->query('SET FOREIGN_KEY_CHECKS=0');
        $db->table('basis_pengetahuan')->truncate();
        $db->table('gejala')->truncate();
        $db->table('penyakit')->truncate();
        $db->query('SET FOREIGN_KEY_CHECKS=1');

        $gejala = [
            ['kode_gejala' => 'G1', 'nama_gejala' => 'Tanaman menjadi kerdil'],
            ['kode_gejala' => 'G2', 'nama_gejala' => 'Tidak berbuah'],
            ['kode_gejala' => 'G3', 'nama_gejala' => 'Tongkolnya tidak normal'],
            ['kode_gejala' => 'G4', 'nama_gejala' => 'Daun berklorosis Sebagian atau seluruh daun'],
            ['kode_gejala' => 'G5', 'nama_gejala' => 'Tanaman menjadi layu'],
            ['kode_gejala' => 'G6', 'nama_gejala' => 'Permukaan Daun berwarna coklat'],
            ['kode_gejala' => 'G7', 'nama_gejala' => 'Terdapat titik merah kecoklatan seperti karat'],
            ['kode_gejala' => 'G8', 'nama_gejala' => 'Terdapat serbuk berwarna kecoklatan'],
            ['kode_gejala' => 'G9', 'nama_gejala' => 'Bangkalan besar pada biji biji tongkol'],
            ['kode_gejala' => 'G10', 'nama_gejala' => 'Bagian biji berwarna gelap'],
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Masa tepung coklat hitam sampai gelap'],
            ['kode_gejala' => 'G12', 'nama_gejala' => 'Daun layu dan kering'],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Pangkal batang berwarna kecoklatan'],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Bagian Dalam batang busuk dan rebah'],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Bagian kulit luar tipis'],
            ['kode_gejala' => 'G16', 'nama_gejala' => 'Bercak kecil berbentuk oval pada daun'],
            ['kode_gejala' => 'G17', 'nama_gejala' => 'Bercak memanjang berbentuk elips'],
            ['kode_gejala' => 'G18', 'nama_gejala' => 'Bercak kering berwarna coklat'],
            ['kode_gejala' => 'G19', 'nama_gejala' => 'Hawar berwarna abu abu seperti terbakar'],
            ['kode_gejala' => 'G20', 'nama_gejala' => 'Daun berwarna mosaik atau hijau'],
            ['kode_gejala' => 'G21', 'nama_gejala' => 'Terdapat garis garis kekuningan sejajar tulang daun'],
            ['kode_gejala' => 'G22', 'nama_gejala' => 'Adanya bekas gigitan pada daun'],
            ['kode_gejala' => 'G23', 'nama_gejala' => 'Pucuk daun layu'],
            ['kode_gejala' => 'G24', 'nama_gejala' => 'Warna daun dari hijau menjadi kekuningan'],
            ['kode_gejala' => 'G25', 'nama_gejala' => 'Batang busuk'],
            ['kode_gejala' => 'G26', 'nama_gejala' => 'Batangnya patah deket permukaan tanah'],
            ['kode_gejala' => 'G27', 'nama_gejala' => 'Adanya bekas gigitan pada batang'],
            ['kode_gejala' => 'G28', 'nama_gejala' => 'Daun tanaman mudah rusak'],
            ['kode_gejala' => 'G29', 'nama_gejala' => 'Tulang daun rusak'],
            ['kode_gejala' => 'G30', 'nama_gejala' => 'Daun menjadi Transparan'],
            ['kode_gejala' => 'G31', 'nama_gejala' => 'Daun berlubang atau sisa tulang tulangnya saja'],
            ['kode_gejala' => 'G32', 'nama_gejala' => 'Lubang gorokan pada batang'],
            ['kode_gejala' => 'G33', 'nama_gejala' => 'Batang mudah patah'],
            ['kode_gejala' => 'G34', 'nama_gejala' => 'Rusaknya tongkol'],
            ['kode_gejala' => 'G35', 'nama_gejala' => 'Ada ulat di tongkol'],
            ['kode_gejala' => 'G36', 'nama_gejala' => 'Terdapat kotoran kotoran di tongkol jagung'],
        ];

        foreach ($gejala as $g) {
            $db->table('gejala')->insert($g);
        }

$penyakit = [
            [
                'kode_penyakit' => 'P1',
                'nama_penyakit' => 'Belalang',
                'solusi' => 'Belalang adalah serangga herbivora yang menyerang tanaman jagung dengan memakan daun, batang, dan tongkol. Serangan berat dapat menyebabkan tanaman kerdil, daun berlubang, dan penurunan hasil panen. Belalang memiliki tubuh memanjang dengan sayap dan kaki belakang yang kuat untuk meloncat.'
            ],
            [
                'kode_penyakit' => 'P2',
                'nama_penyakit' => 'Bercak Daun',
                'solusi' => 'Penyakit bercak daun disebabkan oleh jamur Bipolaris maydis. Gejalanya berupa bercak coklat kecil pada daun yang bisa meluas dan menyebabkan daun menguning dan kering. Infeksi parah dapat mengurangi fotosintesis sehingga mempengaruhi pertumbuhan dan hasil tongkol.'
            ],
            [
                'kode_penyakit' => 'P3',
                'nama_penyakit' => 'Bulai',
                'solusi' => 'Penyakit bulai disebabkan oleh jamur Peronosclerospora sorghi. Gejala khasnya adalah garis-garis kuning pada daun yang tertutup lapisan tepung putih keabu-abuan. Tanaman menjadi kerdil dan tidak menghasilkan tongkol atau tongkolnya kosong. Penyebaran melalui spora dan biji yang terinfeksi.'
            ],
            [
                'kode_penyakit' => 'P4',
                'nama_penyakit' => 'Busuk Batang',
                'solusi' => 'Penyakit busuk batang disebabkan oleh jamur Fusarium moniliforme. Gejala awal berupa perubahan warna pada batang menjadi coklat kehitaman, lalu membusuk dan mudah rebah. Bagian dalam batang dipenuhi miselium putih hingga coklat. Infeksi juga bisa menyerang tongkol.'
            ],
            [
                'kode_penyakit' => 'P5',
                'nama_penyakit' => 'Gosong',
                'solusi' => 'Penyakit gosong atau smut bundel disebabkan oleh jamur Sphacelotheca reiliana. Gejala berupa pembengkakan pada bagian tanaman (batang, daun, atau tongkol) yang berisi massa spora hitam seperti bubuk. Infeksi menyebabkan tanaman tidak menghasilkan tongkol normal.'
            ],
            [
                'kode_penyakit' => 'P6',
                'nama_penyakit' => 'Hawar Daun',
                'solusi' => 'Penyakit hawar daun atau hawar northern leaf blight disebabkan oleh jamur Exserohilum turcicum. Gejala berupa bercak besar berbentuk elips warna abu-abu hingga coklat pada daun. Serangan berat menyebabkan daun kering seperti terbakar dan menurunkan hasil panen secara signifikan.'
            ],
            [
                'kode_penyakit' => 'P7',
                'nama_penyakit' => 'Karat',
                'solusi' => 'Penyakit karat daun disebabkan oleh jamur Puccinia sorghi. Gejala berupa bintik-bintik oranye hingga coklat kemerahan seperti karat pada permukaan daun. Infeksi berat menyebabkan daun menguning dan kering, mengurangi kemampuan fotosintesis tanaman.'
            ],
            [
                'kode_penyakit' => 'P8',
                'nama_penyakit' => 'Lalat Bibit',
                'solusi' => 'Lalatbibit (Atherigona spp.) adalah serangga yang larvanya menyerang tunas dan batang muda tanaman jagung. Larva membuat lubang di dalam batang menyebabkan tanaman layu, menguning, dan mudah patah. Serangan pada fase dini dapat menyebabkan kematian tanaman.'
            ],
            [
                'kode_penyakit' => 'P9',
                'nama_penyakit' => 'Mosaik',
                'solusi' => 'Penyakit mosaik disebabkan oleh virus yang ditularkan oleh kutu kebul. Gejala berupa perubahan warna daun menjadi mosaik hijau muda dan kuning, serta garis-garis kekuningan sejajar tulang daun. Tanaman menjadi kerdil dan produksi berkurang.'
            ],
            [
                'kode_penyakit' => 'P10',
                'nama_penyakit' => 'Penggerek Batang',
                'solusi' => 'Penggerek batang (Ostrinia furnacalis) adalah ngengat yang larvanya menyerang dan membuat lubang di dalam batang jagung. Serangan menyebabkan batang mudah patah, mengganggu transportasi nutrisi, dan menurunkan hasil. Larva juga bisa menyerang tongkol.'
            ],
            [
                'kode_penyakit' => 'P11',
                'nama_penyakit' => 'Penggerek Tongkol',
                'solusi' => 'Penggerek tongkol (Helicoverpa armigera) adalah ngengat yang larvanya menyerang tongkol jagung. Larva memakan biji-biji muda dan membuat lubang pada tongkol. Serangan menyebabkan kerusakan tongkol, biji berkurang, dan mudah diserang jamur sekunder.'
            ],
            [
                'kode_penyakit' => 'P12',
                'nama_penyakit' => 'Ulat Grayak',
                'solusi' => 'Ulat grayak (Spodoptera frugiperda) adalah hama yang sangat berbahaya. Larva memakan daun, meninggalkan pola tulang daun seperti garis-garis. Serangan berat dapat menghabiskan daun hanya dalam beberapa hari, sangat mempengaruhi pertumbuhan tanaman jika tidak dikendalikan.'
            ],
            [
                'kode_penyakit' => 'P13',
                'nama_penyakit' => 'Ulat Tanah',
                'solusi' => 'Ulat tanah (Agrotis spp.) adalah larva ngengat yang menyerang tanaman di malam hari. Ulat memotong batang muda di bagian pangkal sehingga tanaman rebah. Serangan sering terjadi pada awal musim tanam dan dapat menyebabkan kerusakan besar.'
            ],
        ];

        foreach ($penyakit as $p) {
            $db->table('penyakit')->insert($p);
        }

        $basis_pengetahuan = [
            ['id_penyakit' => 1, 'id_gejala' => 1, 'cf' => 0.5],
            ['id_penyakit' => 1, 'id_gejala' => 2, 'cf' => 0.7],
            ['id_penyakit' => 1, 'id_gejala' => 3, 'cf' => 0.7],
            ['id_penyakit' => 1, 'id_gejala' => 4, 'cf' => 0.5],

            ['id_penyakit' => 2, 'id_gejala' => 5, 'cf' => 0.7],
            ['id_penyakit' => 2, 'id_gejala' => 6, 'cf' => 0.7],

            ['id_penyakit' => 3, 'id_gejala' => 7, 'cf' => 0.9],
            ['id_penyakit' => 3, 'id_gejala' => 8, 'cf' => 0.7],

            ['id_penyakit' => 4, 'id_gejala' => 9, 'cf' => 0.8],
            ['id_penyakit' => 4, 'id_gejala' => 10, 'cf' => 0.6],
            ['id_penyakit' => 4, 'id_gejala' => 11, 'cf' => 0.8],

            ['id_penyakit' => 5, 'id_gejala' => 12, 'cf' => 0.6],
            ['id_penyakit' => 5, 'id_gejala' => 13, 'cf' => 0.8],
            ['id_penyakit' => 5, 'id_gejala' => 14, 'cf' => 0.8],
            ['id_penyakit' => 5, 'id_gejala' => 15, 'cf' => 0.8],

            ['id_penyakit' => 6, 'id_gejala' => 16, 'cf' => 0.6],
            ['id_penyakit' => 6, 'id_gejala' => 17, 'cf' => 0.7],
            ['id_penyakit' => 6, 'id_gejala' => 18, 'cf' => 0.8],
            ['id_penyakit' => 6, 'id_gejala' => 19, 'cf' => 0.4],

            ['id_penyakit' => 7, 'id_gejala' => 20, 'cf' => 0.9],
            ['id_penyakit' => 7, 'id_gejala' => 21, 'cf' => 0.7],

            ['id_penyakit' => 8, 'id_gejala' => 22, 'cf' => 1.0],
            ['id_penyakit' => 8, 'id_gejala' => 23, 'cf' => 0.9],
            ['id_penyakit' => 8, 'id_gejala' => 24, 'cf' => 0.8],
            ['id_penyakit' => 8, 'id_gejala' => 25, 'cf' => 0.9],

            ['id_penyakit' => 9, 'id_gejala' => 26, 'cf' => 0.7],
            ['id_penyakit' => 9, 'id_gejala' => 27, 'cf' => 0.6],
            ['id_penyakit' => 9, 'id_gejala' => 28, 'cf' => 0.6],

            ['id_penyakit' => 10, 'id_gejala' => 29, 'cf' => 1.0],

            ['id_penyakit' => 11, 'id_gejala' => 30, 'cf' => 0.8],
            ['id_penyakit' => 11, 'id_gejala' => 31, 'cf' => 0.5],

            ['id_penyakit' => 12, 'id_gejala' => 32, 'cf' => 0.7],
            ['id_penyakit' => 12, 'id_gejala' => 33, 'cf' => 0.6],

            ['id_penyakit' => 13, 'id_gejala' => 34, 'cf' => 1.0],
            ['id_penyakit' => 13, 'id_gejala' => 35, 'cf' => 0.8],
            ['id_penyakit' => 13, 'id_gejala' => 36, 'cf' => 0.5],
        ];

        foreach ($basis_pengetahuan as $bp) {
            $db->table('basis_pengetahuan')->insert($bp);
        }
    }
}