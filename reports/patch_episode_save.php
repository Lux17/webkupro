<?php

$f = dirname(__DIR__) . '/app/Http/Controllers/EpisodeController.php';
$c = file_get_contents($f);

// Sanitize isi_eps whenever taken from request
$c = preg_replace(
    "/'isi_eps'\s*=>\s*\\\$request->isi_eps/",
    "'isi_eps' => \\App\\Support\\HtmlSanitizer::clean(\$request->isi_eps)",
    $c
);

file_put_contents($f, $c);
echo 'clean calls: '.substr_count($c, 'HtmlSanitizer::clean').PHP_EOL;

// APP_DEBUG=false in .env for hardening
$envPath = dirname(__DIR__).'/.env';
if (is_file($envPath)) {
    $env = file_get_contents($envPath);
    $env = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', $env);
    file_put_contents($envPath, $env);
    echo "APP_DEBUG=false\n";
}
