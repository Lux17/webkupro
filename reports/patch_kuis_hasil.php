<?php

$f = dirname(__DIR__) . '/app/Http/Controllers/KuisController.php';
$c = file_get_contents($f);
$start = strpos($c, 'public function hasil(Request $request)');
if ($start === false) {
    echo "hasil not found\n";
    exit(1);
}

$before = substr($c, 0, $start);

$new = <<<'PHP'
public function hasil(Request $request)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        if ($user->rolename !== 'pengguna') {
            abort(403, 'Hanya siswa yang dapat mengirim jawaban kuis.');
        }

        $validated = $request->validate([
            'id_kuis' => ['required', 'integer'],
            'id_mapel' => ['required', 'integer'],
            'jawaban' => ['nullable', 'array'],
            'jawaban.*.id_soal' => ['required_with:jawaban', 'integer'],
            'jawaban.*.pilihan' => ['nullable', 'string', 'max:5'],
        ]);

        $idKuis = (int) $validated['id_kuis'];
        $idMapelReq = (int) $validated['id_mapel'];
        $jawabanUser = $validated['jawaban'] ?? [];

        $kuis = Kuis::where('id_kuis', $idKuis)->first();
        if (! $kuis) {
            abort(404, 'Kuis tidak ditemukan.');
        }

        $idMapel = (int) $kuis->id_mapel;
        if ($idMapelReq !== $idMapel) {
            abort(422, 'Data mapel tidak valid untuk kuis ini.');
        }

        $mapel = Mapel::where('id_mapel', $idMapel)->first();
        if (! $mapel || (int) $mapel->id_kelas !== (int) $user->id_kelas) {
            abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
        }

        $sessionKey = 'quiz_end_'.$idKuis;

        $existing = Jawaban::where('id_user', $user->id)
            ->where('id_kuis', $idKuis)
            ->first();

        if ($existing) {
            session()->forget($sessionKey);

            return view('hasil', [
                'nilai2' => $existing->skor,
                'nilai' => $existing->skor,
            ]);
        }

        $soalDB = Soal::where('kode_kuis', $kuis->kode_kuis)->get()->keyBy('id_soal');
        $totalSoal = $soalDB->count();
        if ($totalSoal === 0) {
            abort(422, 'Kuis belum memiliki soal.');
        }

        $skor = 0;
        $seen = [];
        foreach ($jawabanUser as $j) {
            $idSoal = (int) ($j['id_soal'] ?? 0);
            if ($idSoal <= 0 || isset($seen[$idSoal])) {
                continue;
            }
            $seen[$idSoal] = true;
            if (! isset($soalDB[$idSoal])) {
                continue;
            }
            $pilihan = isset($j['pilihan']) ? strtoupper(trim((string) $j['pilihan'])) : '';
            if ($pilihan !== '' && strtoupper((string) $soalDB[$idSoal]->jawaban) === $pilihan) {
                $skor++;
            }
        }

        $nilaiTotal = (int) round(($skor / $totalSoal) * 100);

        DB::table('jawaban_kuis')->insert([
            'id_user' => $user->id,
            'id_kuis' => $idKuis,
            'id_mapel' => $idMapel,
            'skor' => $nilaiTotal,
            'timestamp' => now(),
        ]);

        session()->forget($sessionKey);

        return view('hasil', ['nilai2' => $nilaiTotal]);
    }

}
PHP;

file_put_contents($f, $before.$new);
echo "KuisController@hasil hardened\n";
