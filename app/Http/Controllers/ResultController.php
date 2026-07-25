<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * POST /result — grade quiz submission (hardened).
     * GET  /result_user{kode_kuis} — show existing score only.
     */
    public function index(Request $request, $kode_kuis = null)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->rolename !== 'pengguna') {
            abort(403, 'Hanya siswa yang dapat mengakses hasil kuis.');
        }

        // GET: view stored result by quiz code (no re-grade).
        if ($request->isMethod('get') || $kode_kuis) {
            return $this->showExisting($user, (string) ($kode_kuis ?? $request->query('kode_kuis', '')));
        }

        return $this->gradeSubmission($request, $user);
    }

    protected function showExisting($user, string $kodeKuis)
    {
        if ($kodeKuis === '') {
            abort(404, 'Kode kuis tidak valid.');
        }

        $kuis = Kuis::where('kode_kuis', $kodeKuis)->first();
        if (! $kuis) {
            abort(404, 'Kuis tidak ditemukan.');
        }

        $mapel = Mapel::where('id_mapel', $kuis->id_mapel)->first();
        if (! $mapel || (int) $mapel->id_kelas !== (int) $user->id_kelas) {
            abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
        }

        $existing = Jawaban::where('id_user', $user->id)
            ->where('id_kuis', $kuis->id_kuis)
            ->first();

        if (! $existing) {
            return redirect()->route('quiz', ['kode_kuis' => $kodeKuis]);
        }

        return view('pengguna.result', [
            'nilai2' => $existing->skor,
            'nilai' => $existing->skor,
        ]);
    }

    protected function gradeSubmission(Request $request, $user)
    {
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

        // Bind mapel from server-side quiz record (ignore client tampering).
        $idMapel = (int) $kuis->id_mapel;
        if ($idMapelReq !== $idMapel) {
            abort(422, 'Data mapel tidak valid untuk kuis ini.');
        }

        // Student may only take quizzes for their own class.
        $mapel = Mapel::where('id_mapel', $idMapel)->first();
        if (! $mapel || (int) $mapel->id_kelas !== (int) $user->id_kelas) {
            abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
        }

        $sessionKey = 'quiz_end_'.$idKuis;

        // Existing attempt: return stored score (no re-grade overwrite).
        $existing = Jawaban::where('id_user', $user->id)
            ->where('id_kuis', $idKuis)
            ->first();

        if ($existing) {
            session()->forget($sessionKey);

            return view('pengguna.result', [
                'nilai2' => $existing->skor,
                'nilai' => $existing->skor,
            ]);
        }

        // Grade only against official soal for this quiz code.
        $soalDB = Soal::where('kode_kuis', $kuis->kode_kuis)
            ->get()
            ->keyBy('id_soal');

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
                // Ignore answers for foreign soal IDs (anti-score injection).
                continue;
            }

            $pilihan = isset($j['pilihan']) ? strtoupper(trim((string) $j['pilihan'])) : '';
            if ($pilihan !== '' && strtoupper((string) $soalDB[$idSoal]->jawaban) === $pilihan) {
                $skor++;
            }
        }

        // Score relative to official total questions, not client-submitted count.
        $nilaiTotal = (int) round(($skor / $totalSoal) * 100);

        DB::table('jawaban_kuis')->insert([
            'id_user' => $user->id,
            'id_kuis' => $idKuis,
            'id_mapel' => $idMapel,
            'skor' => $nilaiTotal,
            'timestamp' => now(),
        ]);

        session()->forget($sessionKey);

        return view('pengguna.result', [
            'nilai2' => $nilaiTotal,
        ]);
    }
}
