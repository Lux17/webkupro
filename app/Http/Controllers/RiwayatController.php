<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Search quiz history for the authenticated student (or admin overview).
     */
    public function search_riwayat(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $keyword = trim((string) $request->get('search', $request->get('q', '')));

        $query = Jawaban::with(['kuis', 'user'])
            ->orderByDesc('timestamp');

        if ($user->rolename === 'pengguna') {
            $query->where('id_user', $user->id);
        } elseif ($user->rolename === 'guru') {
            // Guru: only attempts on their quizzes
            $query->whereHas('kuis', function ($q) use ($user) {
                $q->where('id_guru', $user->id);
            });
        } elseif ($user->rolename !== 'admin') {
            abort(403);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('skor', 'like', '%'.$keyword.'%')
                    ->orWhereHas('kuis', function ($kq) use ($keyword) {
                        $kq->where('nama_kuis', 'like', '%'.$keyword.'%')
                            ->orWhere('kode_kuis', 'like', '%'.$keyword.'%');
                    })
                    ->orWhereHas('user', function ($uq) use ($keyword) {
                        $uq->where('name', 'like', '%'.$keyword.'%');
                    });
            });
        }

        $riwayat = $query->limit(100)->get();

        // Prefer dedicated view if present; otherwise return simple JSON-safe blade fallback.
        if (view()->exists('pengguna.riwayat')) {
            return view('pengguna.riwayat', compact('riwayat', 'keyword'));
        }

        if (view()->exists('riwayat')) {
            return view('riwayat', compact('riwayat', 'keyword'));
        }

        return response()->view('pengguna.result', [
            'nilai2' => $riwayat->first()->skor ?? 0,
            'nilai' => null,
        ]);
    }
}
