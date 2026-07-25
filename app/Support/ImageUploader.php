<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

/**
 * Robust image upload helper for cover photos.
 *
 * Handles common failure cases:
 * - missing / invalid upload
 * - wrong or missing extension (detects real MIME)
 * - uppercase extensions (JPG, JPEG, PNG)
 * - iPhone HEIC (clear error)
 * - oversized files (compress when possible)
 * - missing upload directory
 */
class ImageUploader
{
    /** @var list<string> */
    public const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    /** @var array<string, string> mime => preferred extension */
    public const MIME_MAP = [
        'image/jpeg' => 'jpg',
        'image/pjpeg' => 'jpg',
        'image/png' => 'png',
        'image/x-png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/bmp' => 'bmp',
        'image/x-ms-bmp' => 'bmp',
        'image/x-windows-bmp' => 'bmp',
    ];

    /**
     * Max accepted upload size in kilobytes (10 MB).
     */
    public const MAX_KB = 10240;

    /**
     * Target max dimension (longest side) when compressing.
     */
    public const MAX_DIMENSION = 1920;

    /**
     * JPEG/WebP quality after compress.
     */
    public const COMPRESS_QUALITY = 82;

    /**
     * Store an uploaded image into public/upload and return relative path.
     *
     * @throws RuntimeException with a user-friendly message
     */
    public static function storeCover(?UploadedFile $file, string $directory = 'upload'): string
    {
        if ($file === null) {
            throw new RuntimeException('Cover belum dipilih. Silakan pilih foto terlebih dahulu.');
        }

        if (! $file->isValid()) {
            throw new RuntimeException(self::phpUploadErrorMessage($file->getError()));
        }

        $sizeKb = (int) ceil($file->getSize() / 1024);
        if ($sizeKb > self::MAX_KB) {
            throw new RuntimeException(
                'Ukuran foto terlalu besar (maks. ' . self::formatMb(self::MAX_KB) . '). ' .
                'File Anda sekitar ' . self::formatMb($sizeKb) . '.'
            );
        }

        $mime = self::detectMime($file);
        $ext = self::resolveExtension($file, $mime);

        if ($ext === null) {
            $hint = $mime ? " (tipe terdeteksi: {$mime})" : '';
            throw new RuntimeException(
                'Format foto tidak didukung' . $hint . '. ' .
                'Gunakan JPG, JPEG, PNG, GIF, WEBP, atau BMP. ' .
                'Jika dari iPhone (HEIC), ubah dulu ke JPG di pengaturan Kamera.'
            );
        }

        $absoluteDir = public_path($directory);
        if (! is_dir($absoluteDir) && ! mkdir($absoluteDir, 0755, true) && ! is_dir($absoluteDir)) {
            throw new RuntimeException('Folder upload tidak dapat dibuat. Hubungi administrator.');
        }

        if (! is_writable($absoluteDir)) {
            throw new RuntimeException('Folder upload tidak dapat ditulisi. Hubungi administrator.');
        }

        $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $absolutePath = $absoluteDir . DIRECTORY_SEPARATOR . $fileName;

        // Prefer compressed save for large / high-res photos; fall back to move.
        $stored = self::tryCompressAndSave($file, $absolutePath, $ext);

        if (! $stored) {
            try {
                $file->move($absoluteDir, $fileName);
            } catch (Throwable $e) {
                Log::error('Image upload move failed', [
                    'message' => $e->getMessage(),
                    'mime' => $mime,
                    'ext' => $ext,
                ]);
                throw new RuntimeException('Gagal menyimpan foto. Coba lagi atau gunakan foto lain.');
            }
        }

        if (! is_file($absolutePath)) {
            throw new RuntimeException('Foto gagal tersimpan. Coba unggah ulang.');
        }

        // Always return path without leading slash for consistent asset() usage.
        return trim($directory, '/') . '/' . $fileName;
    }

    /**
     * Laravel validation rules for a required cover image.
     *
     * @return list<string>
     */
    public static function requiredRules(): array
    {
        return [
            'required',
            'file',
            'image',
            'mimes:jpg,jpeg,png,gif,webp,bmp',
            'max:' . self::MAX_KB,
        ];
    }

    /**
     * Laravel validation rules for an optional cover image (update forms).
     *
     * @return list<string>
     */
    public static function optionalRules(): array
    {
        return [
            'nullable',
            'file',
            'image',
            'mimes:jpg,jpeg,png,gif,webp,bmp',
            'max:' . self::MAX_KB,
        ];
    }

    private static function detectMime(UploadedFile $file): ?string
    {
        try {
            $mime = $file->getMimeType();
            if (is_string($mime) && $mime !== '') {
                return strtolower(trim($mime));
            }
        } catch (Throwable) {
            // fall through
        }

        $path = $file->getRealPath() ?: $file->getPathname();
        if ($path && is_file($path) && function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $detected = finfo_file($finfo, $path);
                finfo_close($finfo);
                if (is_string($detected) && $detected !== '') {
                    return strtolower(trim($detected));
                }
            }
        }

        return null;
    }

    private static function resolveExtension(UploadedFile $file, ?string $mime): ?string
    {
        if ($mime && isset(self::MIME_MAP[$mime])) {
            return self::MIME_MAP[$mime];
        }

        // Reject known unsupported camera formats early with null (message handled above).
        if ($mime && (str_contains($mime, 'heic') || str_contains($mime, 'heif'))) {
            return null;
        }

        $ext = strtolower((string) $file->getClientOriginalExtension());
        // Normalize jpeg → jpg for storage consistency.
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }

        if ($ext !== '' && in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            // If MIME is present but unknown, still allow known image extensions
            // when client says it's an image (helps some Android gallery quirks).
            if ($mime === null || str_starts_with($mime, 'image/') || $mime === 'application/octet-stream') {
                return $ext;
            }
        }

        // Guess extension from original name if extension empty.
        $name = strtolower((string) $file->getClientOriginalName());
        if (preg_match('/\.(jpe?g|png|gif|webp|bmp)$/', $name, $m)) {
            $fromName = $m[1] === 'jpeg' ? 'jpg' : $m[1];
            if ($mime === null || str_starts_with((string) $mime, 'image/') || $mime === 'application/octet-stream') {
                return $fromName;
            }
        }

        return null;
    }

    private static function tryCompressAndSave(UploadedFile $file, string $absolutePath, string $ext): bool
    {
        if (! function_exists('imagecreatetruecolor')) {
            return false;
        }

        $sourcePath = $file->getRealPath() ?: $file->getPathname();
        if (! $sourcePath || ! is_file($sourcePath)) {
            return false;
        }

        // Skip compress for small files already under ~1.5 MB unless huge dimensions.
        $info = @getimagesize($sourcePath);
        if ($info === false) {
            return false;
        }

        [$width, $height] = $info;
        $sizeBytes = (int) $file->getSize();
        $needsResize = max($width, $height) > self::MAX_DIMENSION;
        $needsCompress = $sizeBytes > (1500 * 1024);

        if (! $needsResize && ! $needsCompress) {
            return false;
        }

        $src = self::createImageResource($sourcePath, $ext, $info['mime'] ?? null);
        if ($src === false) {
            return false;
        }

        $targetW = $width;
        $targetH = $height;
        if ($needsResize) {
            $scale = self::MAX_DIMENSION / max($width, $height);
            $targetW = max(1, (int) round($width * $scale));
            $targetH = max(1, (int) round($height * $scale));
        }

        $dst = imagecreatetruecolor($targetW, $targetH);
        if ($dst === false) {
            imagedestroy($src);
            return false;
        }

        // Preserve transparency for PNG/GIF/WebP.
        if (in_array($ext, ['png', 'gif', 'webp'], true)) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefilledrectangle($dst, 0, 0, $targetW, $targetH, $transparent);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $targetW, $targetH, $width, $height);
        imagedestroy($src);

        $ok = self::writeImageResource($dst, $absolutePath, $ext);
        imagedestroy($dst);

        return $ok && is_file($absolutePath);
    }

    /**
     * @return \GdImage|resource|false
     */
    private static function createImageResource(string $path, string $ext, ?string $mime)
    {
        $kind = $ext;
        if ($mime) {
            $mapped = self::MIME_MAP[strtolower($mime)] ?? null;
            if ($mapped) {
                $kind = $mapped;
            }
        }

        return match ($kind) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($path),
            'png' => @imagecreatefrompng($path),
            'gif' => @imagecreatefromgif($path),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            'bmp' => function_exists('imagecreatefrombmp') ? @imagecreatefrombmp($path) : false,
            default => false,
        };
    }

    /**
     * @param \GdImage|resource $image
     */
    private static function writeImageResource($image, string $path, string $ext): bool
    {
        return match ($ext) {
            'jpg', 'jpeg' => (bool) @imagejpeg($image, $path, self::COMPRESS_QUALITY),
            'png' => (bool) @imagepng($image, $path, 6),
            'gif' => (bool) @imagegif($image, $path),
            'webp' => function_exists('imagewebp')
                ? (bool) @imagewebp($image, $path, self::COMPRESS_QUALITY)
                : false,
            'bmp' => function_exists('imagebmp')
                ? (bool) @imagebmp($image, $path)
                : false,
            default => false,
        };
    }

    private static function phpUploadErrorMessage(int $errorCode): string
    {
        return match ($errorCode) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE =>
                'Ukuran foto melebihi batas server. Kompres foto atau pilih resolusi lebih kecil.',
            UPLOAD_ERR_PARTIAL =>
                'Upload terputus di tengah jalan. Periksa koneksi lalu unggah ulang.',
            UPLOAD_ERR_NO_FILE =>
                'Cover belum dipilih. Silakan pilih foto terlebih dahulu.',
            UPLOAD_ERR_NO_TMP_DIR =>
                'Folder sementara server tidak tersedia. Hubungi administrator.',
            UPLOAD_ERR_CANT_WRITE =>
                'Server gagal menulis file. Hubungi administrator.',
            UPLOAD_ERR_EXTENSION =>
                'Upload diblokir ekstensi PHP. Hubungi administrator.',
            default =>
                'Upload foto gagal (kode ' . $errorCode . '). Coba foto lain atau ulangi.',
        };
    }

    private static function formatMb(int $kb): string
    {
        if ($kb < 1024) {
            return $kb . ' KB';
        }

        return number_format($kb / 1024, 1) . ' MB';
    }
}
