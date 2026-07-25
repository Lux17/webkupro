<?php

$f = __DIR__ . '/../resources/views/livewire/pages/auth/register.blade.php';
$c = file_get_contents($f);

$c = preg_replace("/\s*public string \\$rolename = 'pengguna';\r?\n/", "\n", $c);

$c = str_replace(
    "            'no_hp' => ['nullable', 'string', 'max:25'],\n            'rolename' => ['nullable', 'string', 'max:25'],\n            'nisn' =>",
    "            'no_hp' => ['nullable', 'string', 'max:25'],\n            'nisn' =>",
    $c
);

$c = str_replace(
    "        \$validated['password'] = Hash::make(\$validated['password']);\n\n        event(new Registered(\$user = User::create(\$validated)));",
    "        \$validated['password'] = Hash::make(\$validated['password']);\n\n        // Force student role server-side — never trust client-supplied rolename.\n        \$user = new User(\$validated);\n        \$user->rolename = 'pengguna';\n        \$user->save();\n\n        event(new Registered(\$user));",
    $c
);

$c = str_replace(
    '<x-text-input class="form-control" wire:model="rolename" id="rolename" name="rolename" type="hidden" />',
    '',
    $c
);

file_put_contents($f, $c);
echo "OK\n";
echo str_contains($c, "\$user->rolename = 'pengguna'") ? "force role: yes\n" : "force role: no\n";
echo str_contains($c, "'rolename' =>") ? "validation still has rolename\n" : "validation clean\n";
echo str_contains($c, 'wire:model="rolename"') ? "hidden field still present\n" : "hidden field removed\n";
