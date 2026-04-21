<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'damnlux17@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), 
            'no_hp' => '08818286473',
            'rolename' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'User1',
            'email' => 'user1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'), 
            'no_hp' => '08977837344',
            'rolename' => 'pengguna',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        );

        DB::table('penyakit')->insert([
            ['id_penyakit' => 1, 'kode_penyakit' => 'P1', 'nama_penyakit' => 'Gagal Ginjal', 'images' => 'images/1721584720.png', 'solusi' => '- Segera Konsultasikan dengan dokter untuk penanganan lebih lanjut, Minum suplemen penambah  zat besi, vitamin B12, asam folat untuk mencegah anemia, Hindari obat-obatan yang dapat merusak ginjal atau meningkatkan risiko kerusakan ginjal lebih lanjut, Membatasi garam dan protein mungkin direkomendasikan untuk membantu menurunkan beban pada ginjal, Cuci darah bila keadaan makin parah.'],
            ['id_penyakit' => 2, 'kode_penyakit' => 'P2', 'nama_penyakit' => 'Batu Ginjal', 'images' => 'images/1719100538.png', 'solusi' => '- Segera Konsultasikan ke dokter untuk pemberian obat, antibiotik dan penghancur batu ginjal (yang diberikan oleh dokter) dan penanganan lebih intensif, Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi, berolahraga secara teratur, dan menjaga berat tubuh ideal, Berikan anak suplemen penambah  zat besi, vitamin B12, asam folat untuk mencegah anemia, Jika diperlukan segera untuk ke rumah sakit untuk melakukan tindakan operasi untuk mengeluarkan batu ginjal.'],
            ['id_penyakit' => 3, 'kode_penyakit' => 'P3', 'nama_penyakit' => 'Kanker Ginjal', 'images' => 'images/1719100553.png', 'solusi' => '- Konsultasi dengan dokter spesialis seperti urolog atau ahli onkologi  evaluasi menyeluruh dan menentukan rencana pengobatan yang sesuai dengan kondisi anak, Berikan dukungan mental dan emosional dari keluarga, teman, dapat membantu Anak mengatasi stres dan kecemasan yang mungkin di alami. Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi, dan berolahraga, Lakukan terapi radiasi, kemoterapi, terapi target atau imunoterapi, Lakukan Cuci darah secara rutin untuk mengeluarkan racun dalam tubuh.'],
            ['id_penyakit' => 4, 'kode_penyakit' => 'P4', 'nama_penyakit' => 'Infeksi Saluran Kemih (ISK)', 'images' => 'images/1719100581.png', 'solusi' => '- Segera Konsultasikan dengan dokter untuk penanganan lebih lanjut, Banyak minum air putih, Gunakan obat pereda demam (dengan resep dokter), Selalu Jaga kebersihan setelah buang air kecil.'],
            ['id_penyakit' => 5, 'kode_penyakit' => 'P5', 'nama_penyakit' => 'Bukan Penyakit Ginjal', 'images' => 'images/1720873902.jpg', 'solusi' => '- Segera Konsultasikan dengan dokter untuk pengecekan penyakit. Selalu jaga pola hidup sehat anak seperti, makan makanan bergizi. Jika gejala semakin memburuk segera untuk ke rumah sakit.'],
        ]);

        DB::table('gejala')->insert([
            ['id_gejala' => 1, 'kode_gejala' => 'G1', 'nama_gejala' => 'Sering menangis/Rewel', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 2, 'kode_gejala' => 'G2', 'nama_gejala' => 'Jumlah Urine sedikit', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 3, 'kode_gejala' => 'G3', 'nama_gejala' => 'Tidak bisa buang air kecil sama sekali', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 4, 'kode_gejala' => 'G4', 'nama_gejala' => 'Warna Urine kecoklatan atau pekat', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 5, 'kode_gejala' => 'G5', 'nama_gejala' => 'Berat badan turun', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 6, 'kode_gejala' => 'G6', 'nama_gejala' => 'Lemas atau Lesu', 'jenis' => 'Gagal Ginjal'],
            ['id_gejala' => 7, 'kode_gejala' => 'G7', 'nama_gejala' => 'Rasa nyeri saat buang air kecil', 'jenis' => 'Batu Ginjal'],
            ['id_gejala' => 8, 'kode_gejala' => 'G8', 'nama_gejala' => 'Urine berwarna merah muda atau merah', 'jenis' => 'Batu Ginjal'],
            ['id_gejala' => 9, 'kode_gejala' => 'G9', 'nama_gejala' => 'Nyeri pada bagian perut bawah', 'jenis' => 'Batu Ginjal'],
            ['id_gejala' => 10, 'kode_gejala' => 'G10', 'nama_gejala' => 'Adanya batu di saluran kemih', 'jenis' => 'Batu Ginjal'],
            ['id_gejala' => 11, 'kode_gejala' => 'G11', 'nama_gejala' => 'Cepat Lelah', 'jenis' => 'Batu Ginjal'],
            ['id_gejala' => 12, 'kode_gejala' => 'G12', 'nama_gejala' => 'Urine berwarna merah muda atau merah', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 13, 'kode_gejala' => 'G13', 'nama_gejala' => 'Sakit Punggung', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 14, 'kode_gejala' => 'G14', 'nama_gejala' => 'Kehilangan nafsu makan', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 15, 'kode_gejala' => 'G15', 'nama_gejala' => 'Kehilangan berat badan', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 16, 'kode_gejala' => 'G16', 'nama_gejala' => 'Pembengkakan Kaki', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 17, 'kode_gejala' => 'G17', 'nama_gejala' => 'Sakit Pata di bagian belakang', 'jenis' => 'Kanker Ginjal'],
            ['id_gejala' => 18, 'kode_gejala' => 'G18', 'nama_gejala' => 'Nyeri pada saat buang air kecil', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 19, 'kode_gejala' => 'G19', 'nama_gejala' => 'Nyeri pada bagian perut bawah', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 20, 'kode_gejala' => 'G20', 'nama_gejala' => 'Nyeri pada punggung bawah atau flanks', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 21, 'kode_gejala' => 'G21', 'nama_gejala' => 'Sering buang air kecil namun tidak tuntas', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 22, 'kode_gejala' => 'G22', 'nama_gejala' => 'Rasa nyeri saat buang air kecil', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 23, 'kode_gejala' => 'G23', 'nama_gejala' => 'Urine berwarna merah muda atau keruh', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 24, 'kode_gejala' => 'G24', 'nama_gejala' => 'Sakit perut atau rasa panas', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 25, 'kode_gejala' => 'G25', 'nama_gejala' => 'Nyeri pada pinggang kanan atau kiri', 'jenis' => 'Infeksi Saluran Kemih (ISK)'],
            ['id_gejala' => 26, 'kode_gejala' => 'G1', 'nama_gejala' => 'Sering menangis/Rewel', 'jenis' => 'Bukan Penyakit Ginjal'],
            ['id_gejala' => 27, 'kode_gejala' => 'G6', 'nama_gejala' => 'Cepat Lelah', 'jenis' => 'Bukan Penyakit Ginjal'],
            ['id_gejala' => 28, 'kode_gejala' => 'G7', 'nama_gejala' => 'Lemas atau Lesu', 'jenis' => 'Bukan Penyakit Ginjal'],
            ['id_gejala' => 29, 'kode_gejala' => 'G9', 'nama_gejala' => 'Sering buang air kecil', 'jenis' => 'Bukan Penyakit Ginjal'],
            ['id_gejala' => 30, 'kode_gejala' => 'G13', 'nama_gejala' => 'Kehilangan nafsu makan', 'jenis' => 'Bukan Penyakit Ginjal'],
            ['id_gejala' => 31, 'kode_gejala' => 'G17', 'nama_gejala' => 'Demam', 'jenis' => 'Bukan Penyakit Ginjal'],
            
        ]);


        DB::table('random_index')->insert([
            ['id_random_index' => 1, 'matrix' => 1, 'nilai' => 0],
            ['id_random_index' => 2, 'matrix' => 2, 'nilai' => 0],
            ['id_random_index' => 3, 'matrix' => 3, 'nilai' => 0.58],
            ['id_random_index' => 4, 'matrix' => 4, 'nilai' => 0.9],
            ['id_random_index' => 5, 'matrix' => 5, 'nilai' => 1.12],
            ['id_random_index' => 6, 'matrix' => 6, 'nilai' => 1.24],
            ['id_random_index' => 7, 'matrix' => 7, 'nilai' => 1.32],
            ['id_random_index' => 8, 'matrix' => 8, 'nilai' => 1.41],
            ['id_random_index' => 9, 'matrix' => 9, 'nilai' => 1.45],
            ['id_random_index' => 10, 'matrix' => 10, 'nilai' => 1.49],
            ['id_random_index' => 11, 'matrix' => 11, 'nilai' => 1.51],
            ['id_random_index' => 12, 'matrix' => 12, 'nilai' => 1.54],
            ['id_random_index' => 13, 'matrix' => 13, 'nilai' => 1.56],
            ['id_random_index' => 14, 'matrix' => 14, 'nilai' => 1.57],
            ['id_random_index' => 15, 'matrix' => 15, 'nilai' => 1.59],
        ]);


        DB::table('kondisi_pengguna')->insert([
            ['id_kondisi' => 1, 'kondisi' => 'Tidak', 'nilai' => 0],
            ['id_kondisi' => 2, 'kondisi' => 'Tidak Tahu', 'nilai' => 0.2],
            ['id_kondisi' => 3, 'kondisi' => 'Kemungkinan', 'nilai' => 0.4],
            ['id_kondisi' => 4, 'kondisi' => 'Kemungkinan Besar', 'nilai' => 0.6],
            ['id_kondisi' => 5, 'kondisi' => 'Hampir Pasti', 'nilai' => 0.8],
            ['id_kondisi' => 6, 'kondisi' => 'Pasti', 'nilai' => 1],
        ]);

    }
}
