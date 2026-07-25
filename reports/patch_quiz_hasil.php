<?php

$f = dirname(__DIR__) . '/app/Http/Controllers/QuizController.php';
$c = file_get_contents($f);
$start = strpos($c, 'public function hasil(Request $request)');
if ($start === false) {
    echo "QuizController hasil not found\n";
    exit(0);
}

$before = substr($c, 0, $start);
$new = <<<'PHP'
public function hasil(Request $request)
    {
        // Hardened: reuse ResultController and map to hasil view if needed.
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        // Delegate scoring to hardened ResultController logic path.
        return app(\App\Http\Controllers\ResultController::class)->index($request);
    }

}
PHP;

file_put_contents($f, $before.$new);
echo "QuizController@hasil delegated\n";

// Fix getTimestampMs compatibility in ResultController
$rf = dirname(__DIR__) . '/app/Http/Controllers/ResultController.php';
$rc = file_get_contents($rf);
$rc = str_replace(
    'Carbon::now()->getTimestampMs()',
    '((int) round(microtime(true) * 1000))',
    $rc
);
file_put_contents($rf, $rc);
echo "ResultController timestamp fixed\n";
