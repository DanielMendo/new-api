<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CleanOrphanImages extends Command
{
    protected $signature = 'clean:images';
    protected $description = 'Eliminar imágenes huérfanas del storage';

    public function handle()
    {
        // 1. Archivos en storage
        $postFiles = Storage::disk('public')->files('images');
        $profileFiles = Storage::disk('public')->files('profile');
        $categoryFiles = Storage::disk('public')->files('categories');

        $allStorageFiles = array_merge($postFiles, $profileFiles, $categoryFiles);

        // 2. Archivos en uso (base de datos)
        $usedPostImages = Post::pluck('image_urls')->flatMap(function ($urls) {
            return collect($urls)->map(fn($url) => 'images/' . basename(parse_url($url, PHP_URL_PATH)));
        });

        $usedProfileImages = User::pluck('profile_image')->map(fn($url) => 'profile/' . basename(parse_url($url, PHP_URL_PATH)));
        $usedCategoryImages = Category::pluck('image')->map(fn($url) => 'categories/' . basename(parse_url($url, PHP_URL_PATH)));

        $usedFiles = $usedPostImages
            ->merge($usedProfileImages)
            ->merge($usedCategoryImages)
            ->unique()
            ->toArray();

        // 3. Identificar huérfanas
        $orphans = array_diff($allStorageFiles, $usedFiles);

        // 4. Mostrar resumen
        $this->info('Total en storage: ' . count($allStorageFiles));
        $this->info('En uso: ' . count($usedFiles));
        $this->info('Huérfanas: ' . count($orphans));

        // 5. Eliminar huérfanas, ignorando avatar.png
        $deletedFiles = 0;
        foreach ($orphans as $file) {
            if (basename($file) === 'avatar.png') {
                continue;
            }

            Storage::disk('public')->delete($file);
            $this->line("Eliminada: $file");
            $deletedFiles++;
        }

        if ($deletedFiles > 0) {
            $this->info('Limpieza completada.');
        } else {
            $this->info('Nada que limpiar.');
        }

        $this->sendTelegramMessage($allStorageFiles, $usedFiles, $deletedFiles);

        return 0;
    }

    public function sendTelegramMessage($allStorageFiles, $usedFiles, $deletedFiles)
    {
        $botToken = '7864854854:AAG76ncuoraT7n3iANDnnbrhcH4Lc8Z8Hb0';
        $chatId = '6762019027';

        $message = "🧹 Limpieza completada:\n";
        $message .= "Total en storage: " . count($allStorageFiles) . "\n";
        $message .= "En uso: " . count($usedFiles) . "\n";
        $message .= "Huérfanas eliminadas: $deletedFiles";

        Http::get("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }
}
