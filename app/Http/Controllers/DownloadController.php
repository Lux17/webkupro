<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    /**
     * Secure download of uploaded learning files.
     * Only authenticated users may download; path traversal is blocked.
     */
    public function unduh(Request $request, int|string $id): BinaryFileResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $file = Files::where('id_files', $id)->first();
        if (! $file) {
            abort(404, 'Berkas tidak ditemukan.');
        }

        $relative = ltrim((string) $file->file, '/\\');
        // Only allow files under public/upload
        $relative = str_replace(['..', '\\'], ['', '/'], $relative);
        if (! str_starts_with($relative, 'upload/')) {
            $relative = 'upload/'.basename($relative);
        }

        $absolute = public_path($relative);
        $uploadRoot = realpath(public_path('upload'));
        $realFile = realpath($absolute);

        if (! $uploadRoot || ! $realFile || ! str_starts_with($realFile, $uploadRoot) || ! is_file($realFile)) {
            abort(404, 'Berkas tidak ditemukan di server.');
        }

        $downloadName = $file->nama_files ?: basename($realFile);

        return response()->download($realFile, $downloadName, [
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
