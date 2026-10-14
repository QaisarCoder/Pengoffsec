<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckAiAssistant extends Command
{
    protected $signature = 'ai:check {--model= : Override the model to test}';

    protected $description = 'Diagnose the Gemini AI assistant configuration and live connectivity';

    public function handle(): int
    {
        $this->newLine();
        $this->line('  PengOffSec AI assistant — diagnostics');
        $this->newLine();

        $ok = true;
        $key = (string) config('services.gemini.key');

        if ($key === '') {
            $this->error('GEMINI_API_KEY   MISSING');
            $this->line('    Add this line to your .env file:');
            $this->line('      <info>GEMINI_API_KEY=your_real_key_here</info>');
            $this->line('    Get a key at https://aistudio.google.com/apikey');
            $this->newLine();
            return self::FAILURE;
        }

        $this->info('GEMINI_API_KEY   SET (' . strlen($key) . ' chars, ending …' . substr($key, -4) . ')');

        $models = $this->option('model')
            ? [(string) $this->option('model')]
            : array_values(array_unique(array_filter(array_merge(
                [(string) config('services.gemini.model')],
                (array) config('services.gemini.fallback_models', [])
            ))));

        $this->line('  Models to try: ' . implode(', ', $models));
        $this->newLine();

        foreach ($models as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}";

            try {
                $response = Http::timeout(30)->post($url, [
                    'contents' => [['role' => 'user', 'parts' => [['text' => 'ping']]]],
                    'generationConfig' => ['responseMimeType' => 'application/json'],
                ]);
            } catch (\Throwable $e) {
                $this->error(str_pad($model, 28) . ' NETWORK — ' . $e->getMessage());
                $ok = false;
                continue;
            }

            if ($response->successful()) {
                $this->info(str_pad($model, 28) . ' OK — reachable and responding');
                continue;
            }

            $status = $response->status();
            $detail = $response->json('error.message') ?? \Illuminate\Support\Str::limit($response->body(), 160);

            $this->error(str_pad($model, 28) . "HTTP {$status} — {$detail}");

            if ($status === 404) {
                $this->line('    This model id does not exist. Set GEMINI_MODEL in .env to a valid id.');
            }
            if ($status === 401 || $status === 403) {
                $this->line('    The API key was rejected. Check GEMINI_API_KEY.');
            }
            if ($status === 429) {
                $this->line('    Quota exceeded or the key is not yet enabled for this API.');
            }

            $ok = false;
        }

        $services = Service::where('is_active', true)->count();
        $this->newLine();
        $this->line('  Active services in catalogue: ' . $services . ($services ? '' : '  <fg=yellow>(the bot will say it has no services)</yellow>'));
        $this->line('  Bookings table (appointments): ' . (\Illuminate\Support\Facades\Schema::hasTable('appointments') ? 'present' : '<fg=red>MISSING — run php artisan migrate</>'));
        $this->line('  Bookings table (a_i_leads):    ' . (\Illuminate\Support\Facades\Schema::hasTable('a_i_leads') ? 'present' : 'absent (optional)'));
        $this->newLine();

        if ($ok) {
            $this->info('  Result: READY');
            $this->newLine();
            return self::SUCCESS;
        }

        $this->error('  Result: NOT READY — fix the items above.');
        $this->newLine();
        return self::FAILURE;
    }
}
