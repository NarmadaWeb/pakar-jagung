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
            ['kode_gejala' => 'G11', 'nama_gejala' => 'Massa tepung coklat hitam sampai gelap'],
            ['kode_gejala' => 'G12', 'nama_gejala' => 'Daun layu dan kering'],
            ['kode_gejala' => 'G13', 'nama_gejala' => 'Pangkal batang berwarna kecoklatan'],
            ['kode_gejala' => 'G14', 'nama_gejala' => 'Bagian dalam batang busuk dan rebah'],
            ['kode_gejala' => 'G15', 'nama_gejala' => 'Bagian kulit luar tipis'],
            ['kode_gejala' => 'G16', 'nama_gejala' => 'Bercak kecil berbentuk oval pada daun'],
            ['kode_gejala' => 'G17', 'nama_gejala' => 'Bercak memanjang berbentuk elips'],
            ['kode_gejala' => 'G18', 'nama_gejala' => 'Bercak kering berwarna coklat'],
            ['kode_gejala' => 'G19', 'nama_gejala' => 'Hawar berwarna abu-abu seperti terbakar'],
            ['kode_gejala' => 'G20', 'nama_gejala' => 'Daun berwarna mosaik atau belang'],
            ['kode_gejala' => 'G21', 'nama_gejala' => 'Terdapat garis-garis kekuningan sejajar tulang daun'],
            ['kode_gejala' => 'G22', 'nama_gejala' => 'Adanya bekas gigitan pada daun'],
            ['kode_gejala' => 'G23', 'nama_gejala' => 'Pucuk daun layu'],
            ['kode_gejala' => 'G24', 'nama_gejala' => 'Warna daun dari hijau menjadi kekuningan'],
            ['kode_gejala' => 'G25', 'nama_gejala' => 'Batang busuk'],
            ['kode_gejala' => 'G26', 'nama_gejala' => 'Batangnya patah dekat permukaan tanah'],
            ['kode_gejala' => 'G27', 'nama_gejala' => 'Adanya bekas gigitan pada batang'],
            ['kode_gejala' => 'G28', 'nama_gejala' => 'Daun tanaman mudah rusak'],
            ['kode_gejala' => 'G29', 'nama_gejala' => 'Tulang daun rusak'],
            ['kode_gejala' => 'G30', 'nama_gejala' => 'Daun menjadi transparan'],
            ['kode_gejala' => 'G31', 'nama_gejala' => 'Daun berlubang atau sisa tulang tulangnya saja'],
            ['kode_gejala' => 'G32', 'nama_gejala' => 'Lubang gorokan pada batang'],
            ['kode_gejala' => 'G33', 'nama_gejala' => 'Batang mudah patah'],
            ['kode_gejala' => 'G34', 'nama_gejala' => 'Rusaknya tongkol'],
            ['kode_gejala' => 'G35', 'nama_gejala' => 'Ada ulat di tongkol'],
            ['kode_gejala' => 'G36', 'nama_gejala' => 'Terdapat kotoran-kotoran di tongkol jagung'],
        ];

        foreach ($gejala as $g) {
            $db->table('gejala')->insert($g);
        }

        $penyakit = [
            [
                'kode_penyakit' => 'P1',
                'nama_penyakit' => 'Belalang',
                'solusi' => 'Belalang adalah serangga herbivora yang menyerang tanaman jagung dengan memakan daun, batang, dan tongkol. Serangan berat dapat menyebabkan tanaman kerdil, daun berlubang, dan penurunan hasil panen.',
                'tindakan_segera' => 'Pantau area yang terkena. Kumpulkan belalang secara manual pada pagi hari saat serangga masih lambat bergerak. Semprotkan pestisida segera jika populasi lebih dari 10 per tanaman.',
                'protokol_pengobatan' => 'Gunakan insektisida yang mengandung karbaryl atau permetrin. Semprotkan pada bagian bawah daun dan batang. Ulangi aplikasi setiap 7 hari hingga populasi terkendali.',
                'strategi_pencegahan' => 'Tanam tanaman penangkap seperti kacang-kacangan sebagai tanaman pengalih. Gunakan varietas jagung yang tahan. Jaga kebersihan lahan dari gulma yang menjadi tempat bersarang.'
            ],
            [
                'kode_penyakit' => 'P2',
                'nama_penyakit' => 'Bercak Daun',
                'solusi' => 'Penyakit bercak daun disebabkan oleh jamur Bipolaris maydis. Gejalanya berupa bercak coklat kecil pada daun yang bisa meluas dan menyebabkan daun menguning dan kering.',
                'tindakan_segera' => 'Pangkas daun yang sangat terkena penyakit. Aplikasikan fungisida yang mengandung mankozeb atau klorotalonil segera setelah gejala terlihat.',
                'protokol_pengobatan' => 'Semprotkan fungisida kontak setiap 7-10 hari. Untuk kasus berat, gunakan fungisida sistemik seperti azoxistrobin. Rotasi bahan aktif untuk menghindari resistensi.',
                'strategi_pencegahan' => 'Gunakan varietas yang tahan terhadap penyakit. Jaga jarak tanam agar sirkulasi udara baik. Hindari penyiraman dari atas, gunakan sistem tetes.'
            ],
            [
                'kode_penyakit' => 'P3',
                'nama_penyakit' => 'Bulai',
                'solusi' => 'Penyakit bulai disebabkan oleh jamur Peronosclerospora sorghi. Gejala khasnya adalah garis-garis kuning pada daun yang tertutup lapisan tepung putih keabu-abuan.',
                'tindakan_segera' => 'Cabut dan musnahkan tanaman yang terkena secepatnya sebelum spora tersebar. Jangan menyentuh tanaman sehat setelah menyentuh tanaman sakit.',
                'protokol_pengobatan' => 'Aplikasikan fungisida yang mengandung metalaksil atau mefenoksam sebagai perlakuan benih. Semprotkan fungisida sistemik pada tanaman muda.',
                'strategi_pencegahan' => 'Gunakan benih bersertifikat yang sudah diberi obat. Tanam varietas yang tahan. Rotasi tanaman dengan tanaman non-pakuan. Kendalikan vektor (kutu kebul) dengan insektisida.'
            ],
            [
                'kode_penyakit' => 'P4',
                'nama_penyakit' => 'Busuk Batang',
                'solusi' => 'Penyakit busuk batang disebabkan oleh jamur Fusarium moniliforme. Gejala awal berupa perubahan warna pada batang menjadi coklat kehitaman, lalu membusuk dan mudah rebah.',
                'tindakan_segera' => 'Cabut tanaman yang terkena untuk mencegah penyebaran. Jangan kompos tanaman yang terkena - bakar atau kubur dalam.',
                'protokol_pengobatan' => 'Aplikasikan fungisida yang mengandung benomil atau karbendazim pada pangkal tanaman. Kombinasikan dengan peningkat ketahanan tanaman.',
                'strategi_pencegahan' => 'Rotasi dengan kacang-kacangan minimal 2 tahun. Hindari stres pada tanaman (kekurangan air, nutrisi berlebih). Gunakan varietas yang tahan. Jaga drainase baik.'
            ],
            [
                'kode_penyakit' => 'P5',
                'nama_penyakit' => 'Gosong',
                'solusi' => 'Penyakit gosong atau smut bundel disebabkan oleh jamur Sphacelotheca reiliana. Gejala berupa pembengkakan pada bagian tanaman yang berisi massa spora hitam.',
                'tindakan_segera' => 'Singkirkan dan musnahkan bagian tanaman yang membengkak sebelum pecah. Jangan biarkan spora tersebar ke tanah.',
                'protokol_pengobatan' => 'Tidak ada obat efektif untuk tanaman yang sudah terkena. Aplikasikan fungisida pada tanaman sehat di sekitarnya sebagai perlindungan.',
                'strategi_pencegahan' => 'Gunakan benih bersertifikat yang sudah diberi fungisida. Gunakan varietas yang tahan. Rotasi tanaman 3-4 tahun. Hindari kerusakan mekanis pada tanaman.'
            ],
            [
                'kode_penyakit' => 'P6',
                'nama_penyakit' => 'Hawar Daun',
                'solusi' => 'Penyakit hawar daun disebabkan oleh jamur Exserohilum turcicum. Gejala berupa bercak besar berbentuk elips warna abu-abu hingga coklat pada daun.',
                'tindakan_segera' => 'Aplikasikan fungisida yang mengandung mankozeb atau propikonazol segera saat gejala pertama muncul.',
                'protokol_pengobatan' => 'Semprotkan fungisida sistemik setiap 14 hari. Kombinasikan azoksistrobin dengan mankozeb untuk hasil optimal.',
                'strategi_pencegahan' => 'Gunakan varietas hibrida yang tahan. Buang sisa tanaman setelah panen. Tanam lebih awal untuk menghindari kondisi optimal bagi jamur.'
            ],
            [
                'kode_penyakit' => 'P7',
                'nama_penyakit' => 'Karat',
                'solusi' => 'Penyakit karat daun disebabkan oleh jamur Puccinia sorghi. Gejala berupa bintik-bintik oranye hingga coklat kemerahan seperti karat pada permukaan daun.',
                'tindakan_segera' => 'Aplikasikan fungisida yang mengandung sulfur atau klorotalonil segera saat daemon pertama terlihat.',
                'protokol_pengobatan' => 'Semprotkan fungisida sistemik (triazol) setiap 10-14 hari hingga 2 minggu sebelum panen.',
                'strategi_pencegahan' => 'Gunakan varietas yang tahan. Hindari pemupukan nitrogen berlebih. Buang daun yang terkena lebih awal. Tanam varietas genjah.'
            ],
            [
                'kode_penyakit' => 'P8',
                'nama_penyakit' => 'Lalat Bibit',
                'solusi' => 'Lalat bibit (Atherigona spp.) adalah serangga yang larvanya menyerang tunas dan batang muda tanaman jagung. Larva membuat lubang di dalam batang.',
                'tindakan_segera' => 'Aplikasikan insektisida yang mengandung karbofuran atau diazinon padabibitan. Cabut dan musnahkan tanaman yang rusak berat.',
                'protokol_pengobatan' => 'Semprotkan insektisida sistemik setiap 3-5 hari sampai tanaman berusia 3 minggu. Gunakan perlakuan benih dengan imidakloprid.',
                'strategi_pencegahan' => 'Tanam lebih awal untuk melewati puncak populasi lalat. Gunakan benih yang sudah diberi obatserangga. Buang sisa tanaman yang menjadi tempat berkembang biak.'
            ],
            [
                'kode_penyakit' => 'P9',
                'nama_penyakit' => 'Mosaik',
                'solusi' => 'Penyakit mosaik disebabkan oleh virus yang ditularkan oleh kutu kebul. Gejala berupa perubahan warna daun menjadi mosaik hijau muda dan kuning.',
                'tindakan_segera' => 'Kendalikan vektor kutu kebul dengan insektisida sistemik. Cabut tanaman yang terkena sangat awal.',
                'protokol_pengobatan' => 'Tidak ada obat untuk virus. Fokus pada pengendalian vektor dengan aplikasi insektisida seperti imidakloprid atau tiametoksam.',
                'strategi_pencegahan' => 'Gunakan varietas yang toleran. Kendalikan kutu kebul dengan perangkap lengket kuning. Basmi gulma yang menjadi inang alternatif. Gunakan mulsa reflektif.'
            ],
            [
                'kode_penyakit' => 'P10',
                'nama_penyakit' => 'Penggerek Batang',
                'solusi' => 'Penggerek batang (Ostrinia furnacalis) adalah ngengat yang larvanya menyerang dan membuat lubang di dalam batang jagung.',
                'tindakan_segera' => 'Suntikkan insektisida yang mengandung karbaryl ke dalam lubang menggunakan alat suntik. Hancurkan larva di dalam dengan kawat.',
                'protokol_pengobatan' => 'Aplikasikan insektisida yang mengandung karbofuran atau klorpirifos pada tanaman 20-30 hari setelah tanam. Gunakan perapas feromon untuk pemantauan.',
                'strategi_pencegahan' => 'Gunakan varietas yang tahan. Rotasi dengan tanaman bukan inang. Tanam lebih awal untuk menghindari puncak populasi. Buang sisa tanaman setelah panen.'
            ],
            [
                'kode_penyakit' => 'P11',
                'nama_penyakit' => 'Penggerek Tongkol',
                'solusi' => 'Penggerek tongkol (Helicoverpa armigera) adalah ngengat yang larvanya menyerang tongkol jagung. Larva memakan biji-biji muda.',
                'tindakan_segera' => 'Petik dan musnahkan larva secara manual. Suntikkan Bacillus thuringiensis (Bt) ke dalam tongkol.',
                'protokol_pengobatan' => 'Aplikasikan insektisida yang mengandung spinosad atau Bt pada tahap pembungaan. Semprotkan saat larva masih kecil (instar 1-2).',
                'strategi_pencegahan' => 'Gunakan varietas dengan tutupan kelobot baik. Tanam lebih awal untuk menghindari serangan puncak. Gunakan perapas feromon untuk pemantauan populasi.'
            ],
            [
                'kode_penyakit' => 'P12',
                'nama_penyakit' => 'Ulat Grayak',
                'solusi' => 'Ulat grayak (Spodoptera frugiperda) adalah hama yang sangat berbahaya. Larva memakan daun, meninggalkan pola tulang daun seperti garis-garis.',
                'tindakan_segera' => 'Aplikasikan insektisida yang mengandung spinosad atau klorantraniliprol segera. Aplikasi pada saat larva masih kecil.',
                'protokol_pengobatan' => 'Semprotkan insektisida sistemik setiap 5-7 hari saat terjadi serangan. Kombinasikan dengan Bt untuk larva muda. Rotasi insektisida untuk menghindari resistensi.',
                'strategi_pencegahan' => 'Gunakan perapas feromon untuk pemantauan. Tanam lebih awal untuk menghindari puncak populasi. Tanam bersamaan dengan kacang-kacangan. Manfaatkan musuh alami seperti Trichogramma.'
            ],
            [
                'kode_penyakit' => 'P13',
                'nama_penyakit' => 'Ulat Tanah',
                'solusi' => 'Ulat tanah (Agrotis spp.) adalah larva ngengat yang menyerang tanaman di malam hari. Ulat memotong batang muda di bagian pangkal.',
                'tindakan_segera' => 'Aplikasikan umpan yang mengandung karbaryl atau metaldehyde di sekitar tanaman. Petik ulat secara manual pada malam hari.',
                'protokol_pengobatan' => 'Aplikasikan insektisida granul containing karbofuran pada tanah di sekitar tanaman. Semprotkan klorpirifos pada malam hari.',
                'strategi_pencegahan' => 'Buang sisa tanaman dan gulma yang menjadi tempat berkembang biak. Penundaan tanam untuk menghindari puncak populasi. Gunakan perangkap cahaya untuk pemantauan.'
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