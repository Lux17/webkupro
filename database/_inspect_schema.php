<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['users', 'kelas', 'mata_pelajaran', 'materi', 'episode', 'files', 'kuis', 'soal', 'jawaban_kuis'];
foreach ($tables as $t) {
    echo "=== {$t} ===\n";
    foreach (DB::select("SHOW COLUMNS FROM `{$t}`") as $c) {
        echo "{$c->Field} | {$c->Type} | null={$c->Null} | key={$c->Key} | def=" . var_export($c->Default, true) . " | {$c->Extra}\n";
    }
    echo 'count=' . DB::table($t)->count() . "\n\n";
}

echo "roles:\n";
foreach (DB::table('users')->select('rolename', DB::raw('count(*) as c'))->groupBy('rolename')->get() as $r) {
    echo "{$r->rolename}: {$r->c}\n";
}

echo "\nsample rows:\n";
foreach (['kelas', 'users', 'mata_pelajaran', 'materi', 'episode', 'files', 'kuis', 'soal', 'jawaban_kuis'] as $t) {
    $row = DB::table($t)->first();
    echo "{$t}: " . json_encode($row) . "\n";
}
