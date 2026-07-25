<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Support\HtmlSanitizer;

$payloads = [
    '<p>Hello</p><script>alert(1)</script>',
    '<img src=x onerror=alert(1)>',
    '<a href="javascript:alert(1)">x</a>',
    '<p style="background:url(javascript:alert(1))">x</p>',
    '<!--comment--><div onclick="alert(1)">ok</div>',
    '<iframe src="https://evil.com"></iframe>',
    '<p>Safe <strong>text</strong></p>',
    '<img src="/upload/test.png" alt="ok">',
];

$fail = 0;
foreach ($payloads as $p) {
    $out = HtmlSanitizer::clean($p);
    $badScript = stripos($out, '<script') !== false;
    $badOn = (bool) preg_match('/\son\w+\s*=/i', $out);
    $badJs = stripos($out, 'javascript:') !== false;
    $status = ($badScript || $badOn || $badJs) ? 'FAIL' : 'PASS';
    if ($status === 'FAIL') {
        $fail++;
    }
    echo "[{$status}]\nIN : {$p}\nOUT: {$out}\n\n";
}

// Mass assignment simulation
$userClass = new ReflectionClass(App\Models\User::class);
$prop = $userClass->getProperty('fillable');
$prop->setAccessible(true);
// Need instance for non-static in some PHP versions - use defaults via new without boot if possible
$u = $userClass->newInstanceWithoutConstructor();
$fillable = $prop->getValue($u);
$hasRole = in_array('rolename', $fillable, true);
echo 'User $fillable has rolename: '.($hasRole ? 'YES (FAIL)' : 'NO (PASS)').PHP_EOL;

// Files validation sample
$fc = file_get_contents(__DIR__.'/../app/Http/Controllers/FilesController.php');
echo 'Files max:102400000 present: '.(str_contains($fc, '102400000') ? 'YES (FAIL)' : 'NO (PASS)').PHP_EOL;
echo 'Files mimes whitelist present: '.(str_contains($fc, "mimes:jpg,jpeg,png") ? 'YES (PASS)' : 'NO (FAIL)').PHP_EOL;
echo 'getClientOriginalName in FilesController: '.(str_contains($fc, 'getClientOriginalName') ? 'YES (WARN)' : 'NO (PASS)').PHP_EOL;

$rc = file_get_contents(__DIR__.'/../app/Http/Controllers/ResultController.php');
echo 'ResultController class binding: '.(str_contains($rc, 'id_kelas') && str_contains($rc, 'totalSoal') ? 'YES (PASS)' : 'NO (FAIL)').PHP_EOL;

echo 'Sanitizer failures: '.$fail.PHP_EOL;
exit($fail > 0 ? 1 : 0);
