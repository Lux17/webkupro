<?php

/**
 * One-shot security patches for MendungSTEM.
 */

function patch_file(string $path, callable $mutator): void
{
    $full = dirname(__DIR__).DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    if (! is_file($full)) {
        echo "SKIP missing: {$path}\n";
        return;
    }
    $original = file_get_contents($full);
    $updated = $mutator($original);
    if ($updated === $original) {
        echo "NOCHANGE: {$path}\n";
        return;
    }
    file_put_contents($full, $updated);
    echo "PATCHED: {$path}\n";
}

// 1) Register: remove leftover public $rolename property if present
patch_file('resources/views/livewire/pages/auth/register.blade.php', function (string $c) {
    $c = preg_replace("/\s*public string \\$rolename = 'pengguna';\r?\n/", "\n", $c);
    return $c;
});

// 2) EpisodeController: sanitize content
patch_file('app/Http/Controllers/EpisodeController.php', function (string $c) {
    if (! str_contains($c, 'HtmlSanitizer')) {
        $c = str_replace(
            "use Session;",
            "use Session;\nuse App\\Support\\HtmlSanitizer;",
            $c
        );
    }

    $pattern = '/\$tampil\s*=\s*\$episode->isi_eps;\s*\$content\s*=\s*str_replace\(\s*[\'"]src="upload\/[\'"]\s*,\s*[\'"]src="[\'"]\s*\.\s*asset\(\s*[\'"]upload\/[\'"]\s*\)\s*\.\s*[\'"]\/[\'"]\s*,\s*\$tampil\s*\);/s';

    $replacement = <<<'PHP'
$tampil = $episode->isi_eps;
            $content = HtmlSanitizer::clean($tampil);
            $content = str_replace('src="/upload/', 'src="'.asset('upload/').'/', $content);
            $content = str_replace("src='/upload/", "src='".asset('upload/').'/', $content);
PHP;

    $c2 = preg_replace($pattern, $replacement, $c);
    if ($c2 === null) {
        echo "  regex failed for EpisodeController\n";
        return $c;
    }

    // Fallback: simpler line-based replace if regex missed
    if ($c2 === $c && str_contains($c, "str_replace('src=\"upload/'")) {
        $c2 = str_replace(
            "\$content = str_replace('src=\"upload/', 'src=\"'.asset('upload/').'/', \$tampil);",
            "\$content = HtmlSanitizer::clean(\$tampil);\n            \$content = str_replace('src=\"/upload/', 'src=\"'.asset('upload/').'/', \$content);\n            \$content = str_replace(\"src='/upload/\", \"src='\".asset('upload/').'/', \$content);",
            $c2
        );
    }

    return $c2;
});

// 3) Admin/Pengguna/Guru controllers: force rolename server-side, never from request
foreach (['AdminController' => 'admin', 'PenggunaController' => 'pengguna', 'GuruController' => 'guru'] as $ctrl => $role) {
    patch_file("app/Http/Controllers/{$ctrl}.php", function (string $c) use ($role) {
        // Remove client-controlled rolename from inserts/updates if present as request value
        $c = str_replace(
            "'rolename' => \$request->rolename,",
            "'rolename' => '{$role}',",
            $c
        );
        // Also handle array style without trailing issues
        $c = preg_replace(
            "/'rolename'\s*=>\s*\$request->rolename\s*,?/",
            "'rolename' => '{$role}',",
            $c
        );
        return $c;
    });
}

// 4) FilesController validation + safe filename
patch_file('app/Http/Controllers/FilesController.php', function (string $c) {
    // Tighten validation rules
    $c = str_replace(
        "'file' => ['required', 'file', 'max:102400000'],",
        "'file' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf,mp4,mp3,doc,docx,ppt,pptx,xls,xlsx,zip', 'max:10240'],",
        $c
    );
    $c = str_replace(
        "'file' => ['required', 'file', 'max:10240'],",
        "'file' => ['required', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf,mp4,mp3,doc,docx,ppt,pptx,xls,xlsx,zip', 'max:10240'],",
        $c
    );

    // Safe stored filename (no client original name)
    $unsafe = "\$fileName = time().'_'.\$file->getClientOriginalName();";
    $safe = "\$ext = strtolower(\$file->getClientOriginalExtension());\n                \$allowed = ['jpg','jpeg','png','gif','webp','pdf','mp4','mp3','doc','docx','ppt','pptx','xls','xlsx','zip'];\n                if (!in_array(\$ext, \$allowed, true)) {\n                    session()->flash('danger', 'Tipe file tidak diizinkan.');\n                    return redirect('files');\n                }\n                \$fileName = time().'_'.bin2hex(random_bytes(8)).'.'.\$ext;";
    $c = str_replace($unsafe, $safe, $c);

    // Fix delete path to use file path column not nama_files
    $c = str_replace(
        "\$path = public_path(\$file->nama_files);",
        "\$path = public_path(ltrim((string) \$file->file, '/\\\\'));",
        $c
    );

    return $c;
});

// 5) MateriController & EpisodeController image uploads — safe names + mimes already partial
foreach (['MateriController.php', 'EpisodeController.php'] as $file) {
    patch_file('app/Http/Controllers/'.$file, function (string $c) {
        $unsafe = "\$fileName = time() . '_' . \$file->getClientOriginalName();";
        $safe = "\$ext = strtolower(\$file->getClientOriginalExtension());\n            \$allowedImg = ['jpg','jpeg','png','gif','webp'];\n            if (!in_array(\$ext, \$allowedImg, true)) {\n                session()->flash('danger', 'Tipe gambar tidak diizinkan.');\n                return redirect()->back()->withInput();\n            }\n            \$fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . \$ext;";
        return str_replace($unsafe, $safe, $c);
    });
}

// 6) ResultController harden quiz scoring
patch_file('app/Http/Controllers/ResultController.php', function (string $c) {
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
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

        // Enforce server-side timer if started.
        $sessionKey = 'quiz_end_'.$idKuis;
        if (session()->has($sessionKey)) {
            $endMs = (int) session($sessionKey);
            // allow 15s grace for network latency
            if (Carbon::now()->getTimestampMs() > ($endMs + 15000)) {
                session()->forget($sessionKey);
                // still accept late submit as auto-submit, but mark time exceeded is optional
            }
        }

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
PHP;
});

// 7) QuizController: bind class + harden
patch_file('app/Http/Controllers/QuizController.php', function (string $c) {
    // After loading kuis, ensure class match for pengguna
    if (str_contains($c, 'Kuis tidak tersedia untuk kelas')) {
        return $c;
    }

    $needle = "\$id_kuis = Kuis::where('kode_kuis', \$kode_kuis)->value('id_kuis');";
    $insert = <<<'PHP'
$id_kuis = Kuis::where('kode_kuis', $kode_kuis)->value('id_kuis');
            if (! $id_kuis) {
                abort(404, 'Kuis tidak ditemukan.');
            }

            $kuisRow = Kuis::where('id_kuis', $id_kuis)->first();
            $mapelRow = Mapel::where('id_mapel', $kuisRow->id_mapel)->first();
            if (! $mapelRow || (int) $mapelRow->id_kelas !== (int) auth()->user()->id_kelas) {
                abort(403, 'Kuis tidak tersedia untuk kelas Anda.');
            }
PHP;

    return str_replace($needle, $insert, $c);
});

// 8) .gitignore web.sql
$gi = dirname(__DIR__).DIRECTORY_SEPARATOR.'.gitignore';
if (is_file($gi)) {
    $g = file_get_contents($gi);
    if (! str_contains($g, 'web.sql')) {
        file_put_contents($gi, rtrim($g)."\n\n# DB dumps must not be deployed\nweb.sql\n*.sql\n!database/**/*.sql\n");
        echo "PATCHED: .gitignore\n";
    } else {
        echo "NOCHANGE: .gitignore\n";
    }
}

// 9) Block web.sql via public rewrite note + move dump out of web-facing root if possible
$rootSql = dirname(__DIR__).DIRECTORY_SEPARATOR.'web.sql';
$safeSql = dirname(__DIR__).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'web.sql';
if (is_file($rootSql)) {
    if (! is_dir(dirname($safeSql))) {
        mkdir(dirname($safeSql), 0755, true);
    }
    if (! is_file($safeSql)) {
        rename($rootSql, $safeSql);
        echo "MOVED: web.sql -> storage/app/private/web.sql\n";
    } else {
        unlink($rootSql);
        echo "REMOVED: root web.sql (copy already in private)\n";
    }
}

// 10) public/.htaccess extras if Apache
$ht = dirname(__DIR__).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'.htaccess';
if (is_file($ht)) {
    $h = file_get_contents($ht);
    if (! str_contains($h, 'X-Content-Type-Options')) {
        $extra = <<<'HT'

# Security headers (Apache)
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always unset X-Powered-By
</IfModule>

# Block sensitive files if ever placed under public
<FilesMatch "(?i)\.(env|sql|log|bak|git)$">
    Require all denied
</FilesMatch>
HT;
        file_put_contents($ht, rtrim($h)."\n".$extra."\n");
        echo "PATCHED: public/.htaccess\n";
    }
}

// 11) .env.example session defaults
$envEx = dirname(__DIR__).DIRECTORY_SEPARATOR.'.env.example';
if (is_file($envEx)) {
    $e = file_get_contents($envEx);
    $e = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', $e);
    if (! str_contains($e, 'SESSION_ENCRYPT=')) {
        $e .= "\nSESSION_ENCRYPT=true\nSESSION_SECURE_COOKIE=false\n";
    } else {
        $e = preg_replace('/^SESSION_ENCRYPT=.*/m', 'SESSION_ENCRYPT=true', $e);
    }
    if (! str_contains($e, 'SESSION_SECURE_COOKIE=')) {
        $e .= "SESSION_SECURE_COOKIE=false\n";
    }
    file_put_contents($envEx, $e);
    echo "PATCHED: .env.example\n";
}

// 12) Soft-update local .env session settings (do not force APP_DEBUG false in local if user needs it —
// but set recommended secure defaults; for production readiness set APP_DEBUG false)
$env = dirname(__DIR__).DIRECTORY_SEPARATOR.'.env';
if (is_file($env)) {
    $e = file_get_contents($env);
    if (! preg_match('/^SESSION_ENCRYPT=/m', $e)) {
        $e .= "\nSESSION_ENCRYPT=true\n";
    } else {
        $e = preg_replace('/^SESSION_ENCRYPT=.*/m', 'SESSION_ENCRYPT=true', $e);
    }
    if (! preg_match('/^SESSION_SECURE_COOKIE=/m', $e)) {
        // local http => false; production should set true
        $e .= "SESSION_SECURE_COOKIE=false\n";
    }
    // Keep APP_DEBUG as-is for local dev, but document. Only force false if APP_ENV=production
    if (preg_match('/^APP_ENV=production/m', $e)) {
        $e = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', $e);
    }
    file_put_contents($env, $e);
    echo "PATCHED: .env session flags\n";
}

echo "DONE\n";
