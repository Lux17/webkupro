<?php

/**
 * One-off dummy data seeder.
 * Inserts ~50 rows into application tables.
 * Does NOT create/modify users with rolename = admin.
 * Does NOT alter schema or application code permanently.
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

function out(string $msg): void
{
    echo $msg . PHP_EOL;
}

function ensureCount(string $table, int $target, callable $insertOne, string $label = null): int
{
    $label = $label ?? $table;
    $current = (int) DB::table($table)->count();
    if ($current >= $target) {
        out("[skip] {$label}: already {$current} rows (>= {$target})");
        return 0;
    }

    $need = $target - $current;
    $inserted = 0;
    for ($i = 0; $i < $need; $i++) {
        $insertOne($current + $i + 1, $i);
        $inserted++;
    }
    out("[ok] {$label}: inserted {$inserted} (now " . DB::table($table)->count() . ")");
    return $inserted;
}

$TARGET = 50;
$password = Hash::make('password');
$now = now();

out('=== Dummy seed start (target ' . $TARGET . ' per table) ===');
out('Admin users will NOT be created or modified.');

DB::beginTransaction();

try {
    // -------------------------------------------------
    // 1) KELAS
    // -------------------------------------------------
    ensureCount('kelas', $TARGET, function ($n) use ($now) {
        // avoid unique collisions if id_kelas is unique-ish in app logic
        $idKelas = 'KLS' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
        // if id_kelas already exists, append random
        if (DB::table('kelas')->where('id_kelas', $idKelas)->exists()) {
            $idKelas = 'KLS' . $n . Str::upper(Str::random(3));
        }
        DB::table('kelas')->insert([
            'id_kelas' => $idKelas,
            'nama_kelas' => 'Kelas Dummy ' . $n,
        ]);
    });

    $kelasIds = DB::table('kelas')->pluck('id_kelas')->all();
    if (empty($kelasIds)) {
        throw new RuntimeException('No kelas rows available.');
    }

    // -------------------------------------------------
    // 2) USERS – guru (50)
    // -------------------------------------------------
    $guruCount = (int) DB::table('users')->where('rolename', 'guru')->count();
    if ($guruCount < $TARGET) {
        $need = $TARGET - $guruCount;
        for ($i = 0; $i < $need; $i++) {
            $n = $guruCount + $i + 1;
            $email = 'guru.dummy' . $n . '@example.com';
            if (DB::table('users')->where('email', $email)->exists()) {
                $email = 'guru.dummy' . $n . '.' . Str::lower(Str::random(4)) . '@example.com';
            }
            DB::table('users')->insert([
                'name' => 'Guru Dummy ' . $n,
                'email' => $email,
                'email_verified_at' => $now,
                'password' => $password,
                'rolename' => 'guru',
                'jenis_kelamin' => ($n % 2 === 0) ? 'Laki-laki' : 'Perempuan',
                'no_hp' => '08' . str_pad((string) (1000000000 + $n), 10, '0', STR_PAD_LEFT),
                'alamat' => 'Alamat Guru Dummy No. ' . $n,
                'riwayat_penyakit' => null,
                'tgl_lahir' => date('Y-m-d', strtotime('1980-01-01 +' . ($n % 8000) . ' days')),
                'nisn' => null,
                'nip' => 'NIP' . str_pad((string) $n, 8, '0', STR_PAD_LEFT),
                'id_kelas' => null,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        out("[ok] users(guru): inserted {$need} (now " . DB::table('users')->where('rolename', 'guru')->count() . ")");
    } else {
        out("[skip] users(guru): already {$guruCount}");
    }

    // -------------------------------------------------
    // 3) USERS – pengguna/siswa (50)
    // -------------------------------------------------
    $siswaCount = (int) DB::table('users')->where('rolename', 'pengguna')->count();
    if ($siswaCount < $TARGET) {
        $need = $TARGET - $siswaCount;
        for ($i = 0; $i < $need; $i++) {
            $n = $siswaCount + $i + 1;
            $email = 'siswa.dummy' . $n . '@example.com';
            if (DB::table('users')->where('email', $email)->exists()) {
                $email = 'siswa.dummy' . $n . '.' . Str::lower(Str::random(4)) . '@example.com';
            }
            DB::table('users')->insert([
                'name' => 'Siswa Dummy ' . $n,
                'email' => $email,
                'email_verified_at' => $now,
                'password' => $password,
                'rolename' => 'pengguna',
                'jenis_kelamin' => ($n % 2 === 0) ? 'Laki-laki' : 'Perempuan',
                'no_hp' => '08' . str_pad((string) (2000000000 + $n), 10, '0', STR_PAD_LEFT),
                'alamat' => 'Alamat Siswa Dummy No. ' . $n,
                'riwayat_penyakit' => null,
                'tgl_lahir' => date('Y-m-d', strtotime('2008-01-01 +' . ($n % 2000) . ' days')),
                'nisn' => 'NISN' . str_pad((string) $n, 6, '0', STR_PAD_LEFT),
                'nip' => null,
                'id_kelas' => $kelasIds[($n - 1) % count($kelasIds)],
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        out("[ok] users(pengguna): inserted {$need} (now " . DB::table('users')->where('rolename', 'pengguna')->count() . ")");
    } else {
        out("[skip] users(pengguna): already {$siswaCount}");
    }

    // Confirm no new admin created
    $adminCount = (int) DB::table('users')->where('rolename', 'admin')->count();
    out("[info] users(admin) untouched, count={$adminCount}");

    $guruIds = DB::table('users')->where('rolename', 'guru')->pluck('id')->all();
    $siswaIds = DB::table('users')->where('rolename', 'pengguna')->pluck('id')->all();
    if (empty($guruIds) || empty($siswaIds)) {
        throw new RuntimeException('Need guru and pengguna users for related tables.');
    }

    // -------------------------------------------------
    // 4) MATA PELAJARAN
    // -------------------------------------------------
    ensureCount('mata_pelajaran', $TARGET, function ($n) use ($kelasIds, $guruIds) {
        $idMapel = 'MPL' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
        if (DB::table('mata_pelajaran')->where('id_mapel', $idMapel)->exists()) {
            $idMapel = 'MPL' . $n . Str::upper(Str::random(3));
        }
        DB::table('mata_pelajaran')->insert([
            'id_mapel' => $idMapel,
            'nama_mapel' => 'Mapel Dummy ' . $n,
            'id_kelas' => $kelasIds[($n - 1) % count($kelasIds)],
            'id_guru' => $guruIds[($n - 1) % count($guruIds)],
        ]);
    });

    $mapelIds = DB::table('mata_pelajaran')->pluck('id_mapel')->all();
    $mapelRows = DB::table('mata_pelajaran')->get(['id_mapel', 'id_guru', 'id_kelas']);
    if ($mapelRows->isEmpty()) {
        throw new RuntimeException('No mapel rows available.');
    }

    // -------------------------------------------------
    // 5) MATERI
    // -------------------------------------------------
    ensureCount('materi', $TARGET, function ($n) use ($mapelRows, $now) {
        $mapel = $mapelRows[($n - 1) % $mapelRows->count()];
        DB::table('materi')->insert([
            'title' => 'Materi Dummy ' . $n,
            'content' => 'Konten materi dummy nomor ' . $n . '. Ini adalah data uji coba untuk platform MendungSTEM.',
            'tgl' => date('Y-m-d', strtotime('-' . ($n % 60) . ' days')),
            'id_mapel' => $mapel->id_mapel,
            'id_guru' => $mapel->id_guru,
        ]);
    });

    $materiIds = DB::table('materi')->pluck('id')->all();
    // materi primary key might not be "id" — detect
    if (empty($materiIds)) {
        // try common alternate
        $materiIds = DB::table('materi')->pluck('id_materi')->all();
    }

    // -------------------------------------------------
    // 6) EPISODE
    // -------------------------------------------------
    // re-fetch materi with flexible PK
    $materiCols = collect(DB::select('SHOW COLUMNS FROM materi'))->pluck('Field')->all();
    $materiPk = in_array('id_materi', $materiCols, true) ? 'id_materi' : 'id';
    $materiIds = DB::table('materi')->pluck($materiPk)->all();
    if (empty($materiIds)) {
        throw new RuntimeException('No materi rows for episode FK.');
    }

    ensureCount('episode', $TARGET, function ($n) use ($materiIds) {
        DB::table('episode')->insert([
            'nama_eps' => 'Episode Dummy ' . $n,
            'isi_eps' => 'Isi episode dummy nomor ' . $n . '. Penjelasan materi etno-STEM untuk pengujian.',
            'type' => ($n % 3 === 0) ? 'video' : (($n % 3 === 1) ? 'teks' : 'gambar'),
            'id_materi' => $materiIds[($n - 1) % count($materiIds)],
            'tgl' => date('Y-m-d', strtotime('-' . ($n % 45) . ' days')),
            'img' => null,
        ]);
    });

    // -------------------------------------------------
    // 7) FILES
    // -------------------------------------------------
    $userIdsForFiles = array_values(array_merge($guruIds, $siswaIds));
    ensureCount('files', $TARGET, function ($n) use ($userIdsForFiles) {
        $idFiles = 'FIL' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
        if (DB::table('files')->where('id_files', $idFiles)->exists()) {
            $idFiles = 'FIL' . $n . Str::upper(Str::random(3));
        }
        DB::table('files')->insert([
            'nama_files' => 'file_dummy_' . $n . '.pdf',
            'id_files' => $idFiles,
            'tgl' => date('Y-m-d', strtotime('-' . ($n % 30) . ' days')),
            'id_user' => $userIdsForFiles[($n - 1) % count($userIdsForFiles)],
        ]);
    });

    // -------------------------------------------------
    // 8) KUIS
    // -------------------------------------------------
    ensureCount('kuis', $TARGET, function ($n) use ($mapelRows, $now) {
        $mapel = $mapelRows[($n - 1) % $mapelRows->count()];
        $kode = 'KUIS' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
        if (DB::table('kuis')->where('kode_kuis', $kode)->exists()) {
            $kode = 'KUIS' . $n . Str::upper(Str::random(3));
        }
        DB::table('kuis')->insert([
            'durasi' => 30 + ($n % 60),
            'id_mapel' => $mapel->id_mapel,
            'id_guru' => $mapel->id_guru,
            'kode_kuis' => $kode,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    });

    $kuisRows = DB::table('kuis')->get();
    if ($kuisRows->isEmpty()) {
        throw new RuntimeException('No kuis rows.');
    }

    // detect kuis PK
    $kuisCols = collect(DB::select('SHOW COLUMNS FROM kuis'))->pluck('Field')->all();
    $kuisPk = in_array('id_kuis', $kuisCols, true) ? 'id_kuis' : 'id';

    // -------------------------------------------------
    // 9) SOAL
    // -------------------------------------------------
    ensureCount('soal', $TARGET, function ($n) use ($kuisRows, $kuisPk) {
        $kuis = $kuisRows[($n - 1) % $kuisRows->count()];
        $jawaban = ['A', 'B', 'C', 'D', 'E'][($n - 1) % 5];
        DB::table('soal')->insert([
            'durasi' => 60,
            'pertanyaan' => 'Soal dummy nomor ' . $n . ': manakah jawaban yang benar?',
            'opsi_a' => 'Opsi A untuk soal ' . $n,
            'opsi_b' => 'Opsi B untuk soal ' . $n,
            'opsi_c' => 'Opsi C untuk soal ' . $n,
            'opsi_d' => 'Opsi D untuk soal ' . $n,
            'opsi_e' => 'Opsi E untuk soal ' . $n,
            'jawaban' => $jawaban,
            'kode_kuis' => $kuis->kode_kuis,
            'id_mapel' => $kuis->id_mapel,
            'id_guru' => $kuis->id_guru,
        ]);
    });

    // -------------------------------------------------
    // 10) JAWABAN_KUIS
    // -------------------------------------------------
    $jawabanCols = collect(DB::select('SHOW COLUMNS FROM jawaban_kuis'))->pluck('Field')->all();
    ensureCount('jawaban_kuis', $TARGET, function ($n) use ($siswaIds, $kuisRows, $kuisPk, $jawabanCols, $now) {
        $kuis = $kuisRows[($n - 1) % $kuisRows->count()];
        $row = [
            'id_user' => $siswaIds[($n - 1) % count($siswaIds)],
            'id_mapel' => $kuis->id_mapel,
            'skor' => ($n * 7) % 101,
            'id_kuis' => $kuis->{$kuisPk},
        ];
        if (in_array('timestamp', $jawabanCols, true)) {
            $row['timestamp'] = date('Y-m-d H:i:s', strtotime('-' . ($n % 20) . ' days'));
        }
        if (in_array('created_at', $jawabanCols, true)) {
            $row['created_at'] = $now;
        }
        if (in_array('updated_at', $jawabanCols, true)) {
            $row['updated_at'] = $now;
        }
        DB::table('jawaban_kuis')->insert($row);
    });

    DB::commit();

    out('');
    out('=== Final counts ===');
    $tables = [
        'kelas',
        'users',
        'mata_pelajaran',
        'materi',
        'episode',
        'files',
        'kuis',
        'soal',
        'jawaban_kuis',
    ];
    foreach ($tables as $t) {
        out(sprintf('%-16s %d', $t, DB::table($t)->count()));
    }
    out(sprintf('%-16s %d', 'users.admin', DB::table('users')->where('rolename', 'admin')->count()));
    out(sprintf('%-16s %d', 'users.guru', DB::table('users')->where('rolename', 'guru')->count()));
    out(sprintf('%-16s %d', 'users.pengguna', DB::table('users')->where('rolename', 'pengguna')->count()));
    out('');
    out('Password default dummy users: password');
    out('=== Done ===');
} catch (Throwable $e) {
    DB::rollBack();
    out('[ERROR] ' . $e->getMessage());
    out($e->getFile() . ':' . $e->getLine());
    exit(1);
}
