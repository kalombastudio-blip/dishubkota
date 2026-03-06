<?php

namespace App\Foundation;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * Override bootstrap path untuk Vercel (read-only filesystem).
     * Redirect ke /tmp yang writable di serverless environment.
     */
    public function bootstrapPath($path = '')
    {
        if ($this->isVercel()) {
            $tmpPath = '/tmp/bootstrap';
            if (!is_dir($tmpPath . '/cache')) {
                mkdir($tmpPath . '/cache', 0755, true);
            }
            return $tmpPath . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
        }

        return parent::bootstrapPath($path);
    }

    /**
     * Override storage path untuk Vercel.
     */
    public function storagePath($path = '')
    {
        if ($this->isVercel()) {
            $tmpStorage = '/tmp/storage';
            // Buat semua subfolder yang dibutuhkan Laravel
            foreach ([
                'framework/cache/data',
                'framework/sessions',
                'framework/views',
                'logs',
                'app/public',
            ] as $dir) {
                if (!is_dir($tmpStorage . '/' . $dir)) {
                    mkdir($tmpStorage . '/' . $dir, 0755, true);
                }
            }
            return $tmpStorage . ($path !== '' ? DIRECTORY_SEPARATOR . $path : '');
        }

        return parent::storagePath($path);
    }

    /**
     * Deteksi apakah berjalan di Vercel serverless.
     */
    protected function isVercel(): bool
    {
        return isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']);
    }
}
